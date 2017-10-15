<?php

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


function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}

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

deleteDirectory($path);

?>
