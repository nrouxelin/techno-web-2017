<?php
class RecetteControleur extends Controleur{

    public function afficher(){
        $slug               = $this->route["params"]["slug"];
        $this->vue->recette = Recette::getFromSlug($slug);
        $this->vue->afficher();
    }
}

 ?>
