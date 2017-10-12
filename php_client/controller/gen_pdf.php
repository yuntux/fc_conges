<?php

function generate_pdf($html_input,$id_pdf,$nom_fichier){
	require_once('../tcpdf/config/lang/fra.php');
	require_once('../tcpdf/tcpdf.php');



	//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf = new TCPDF("LANDSCAPE", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	// set header and footer fonts
	//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	//set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	//set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	//set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	//set some language-dependent strings
	$pdf->setLanguageArray($l);

	// ---------------------------------------------------------

	// add a page
	$pdf->AddPage();

	$pdf->SetFont('helvetica', '', 8);
	// -----------------------------------------------------------------------------

	// Set some content to print
	$css = file_get_contents('../view/Style.css');
	$contenu_html = '<html lang="fr">
        <head>
		<meta charset="utf-8">
                <title>FC congès</title>
                <link rel="stylesheet" media="screen" type="text/css" href="../view/Style.css" />
<style>.solid_table table

{

    border-collapse: collapse;

}

.solid_table td, th /* Mettre une bordure sur les td ET les th */

{

    border-collapse: collapse;
    border: 1px solid black;

}
</style>
        </head>
        <body>'.$contenu_html.'
	</body>
	</html>';

	$contenu_html= explode( '<---- TDPDF_PAGE_BREAK ---->', $html_input);

	foreach ($contenu_html as $page){
		$pdf->writeHTML($page, true, false, false, false, '');
		$pdf->AddPage();
	}
	// Print text using writeHTMLCell()
	//$pdf->writeHTML($contenu_html, true, false, false, false, '');

	// This method has several options, check the source code documentation for more information.
	$pdf->Output($nom_fichier.'.pdf', 'I');
}

//echo base64_decode($_POST['html_content']);
//generate_pdf(base64_decode($_POST['html_content']),"1","Fiches mensuelles");


	$css = file_get_contents('../view/Style.css');
	$contenu_html = '<html lang="fr">
        <head>
		<meta charset="utf-8">
                <title>FC congès</title>
                <link rel="stylesheet" media="screen" type="text/css" href="../view/Style.css" />
<style>.solid_table table

{

    border-collapse: collapse;

}

.solid_table td, th /* Mettre une bordure sur les td ET les th */

{

    border-collapse: collapse;
    border: 1px solid black;

}
</style>
        </head>
        <body>'.base64_decode($_POST['html_content']).'
	</body>
	</html>';

	//$contenu_html= explode( '<---- TDPDF_PAGE_BREAK ---->', $html_input);


$id = uniqid();
$path = '/tmp/'.$id;
mkdir($path);
$html_path = $path."/fichier.html";
$pdf_path = $path."/fichier.pdf";
$html_file = fopen($html_path, 'w+');
fputs($html_file,$contenu_html);
fclose($html_file);
exec("../../wkhtmltox/bin/wkhtmltopdf -O landscape ".$html_path." ".$pdf_path);
$pdf = file_get_contents($pdf_path);

header('Content-Type: application/pdf');
header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
header('Pragma: public');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Content-Length: '.strlen($pdf));
//header('Content-Disposition: inline; filename="'.basename($file).'";');
ob_clean(); 
flush(); 
echo $pdf;

rmdir($path);

?>
