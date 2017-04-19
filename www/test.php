<?php
include("../app/noyau/Formulaire.php");
$formulaire = new Formulaire("test.php","post");
$formulaire->ajouterChamp("input","nom","Nom");
$formulaire->ajouterChamp("password","mot_passe","Mot de passe");
$formulaire->ajouterChamp("submit","submit",'Envoyer');
$formulaire->afficherFormulaire();


?>
