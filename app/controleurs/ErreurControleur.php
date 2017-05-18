<?php

class ErreurControleur extends Controleur{

    public function erreur404(){
        $this->vue->setTitre("Page introuvable.");
        $this->vue->afficher();
    }

    public function erreur403(){
        $this->vue->SetTitre("Action interdite.");
        $this->vue->afficher();
    }
}

 ?>
