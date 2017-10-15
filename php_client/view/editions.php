editions periodiques : congès du mois pour la paye, sauvegarde de toutes les demandes en cours, PDF mensuel de validation / ricket restau

<form action="?action=editions" method="post">
<h2>Fiches récapitulatives individuelles</h2>
Date de début : <input type="date" name="debut_periode" value="<?php echo $first_day_month ?>">
<br>Date de fin : <input type="date" name="fin_periode" value="<?php echo $last_day_month ?>">
<br><input type="submit" value="Générer PDF" name="bouton_recap_individuel"/>
</form>
