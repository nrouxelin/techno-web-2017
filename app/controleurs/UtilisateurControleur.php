<?php

class UtilisateurControleur extends Controleur{

    public function s_inscrire(){
        //Création du formulaire
        $action = Router::obtenirRoute("Utilisateur","ajouter");
        $formulaire = new Formulaire($action,"post");
        $formulaire->ajouterChamp("input","nom","Votre nom :");
        $formulaire->ajouterChamp("password","mot_passe","Votre mot de passe :");
        $formulaire->ajouterChamp("password","confirmation","Confirmez :");
        $formulaire->ajouterChamp("email","email","Votre adresse email :");
        $formulaire->ajouterChamp("submit","submit","S'inscrire");

        $this->vue->Formulaire = $formulaire;
        $this->vue->setTitre("Inscription");
        $this->vue->afficher();
    }

}

 ?>
