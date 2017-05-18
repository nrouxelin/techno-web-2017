<?php

class AccueilCOntroleur extends Controleur{

    public function afficher(){
        $this->vue->setTitre("Accueil");
        $this->vue->afficher();
    }
}

 ?>
