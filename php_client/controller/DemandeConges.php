<?php
	$reponse1 =$CONSULTANT->get_manager_list();

	if(isset($_POST['Envoyer'])){
		$dateFromDu=$_POST['dateFromDu'];
		$dateFromAu=$_POST['dateFromAu'];
		$thelistMM=$_POST['thelistMM'];
		$thelistMS=$_POST['thelistMS'];
		$thelistDM=$_POST['thelistDM'];
		$commentaire=$_POST['commentaire'];
		$nbjrsSS=$_POST['nbjrsSS'];
		$nbjrsAutres=$_POST['nbjrsAutres'];
		$nbjrsConv=$_POST['nbjrsConv'];
		$nbjrsRTT=$_POST['nbjrsRTT'];
		$nbjrsCP=$_POST['nbjrsCP'];
		
		$DEMANDE->enregistrer_demande($dateFromDu,$dateFromAu,$thelistMM,$thelistMS,$thelistDM,$commentaire,$nbjrsSS,$nbjrsAutres,$nbjrsConv,$nbjrsRTT,$nbjrsCP);
	}

	$view_to_display='DemandeConges.php';
?>
