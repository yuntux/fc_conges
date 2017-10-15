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
		
		$res = $DEMANDE->enregistrer_demande($dateFromDu,$dateFromAu,$thelistMM,$thelistMS,$thelistDM,$commentaire,$nbjrsSS,$nbjrsAutres,$nbjrsConv,$nbjrsRTT,$nbjrsCP);
		if ($res == True){
			$message_succes = "Demande de congés enregistrée.";
			$view_to_display='home.php';
		} else {
			$message_erreur = $res;
			$view_to_display='DemandeConges.php';
		}
	} else {
		$view_to_display='DemandeConges.php';
	}
?>
