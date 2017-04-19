<?php
class RecetteControleur extends Controleur{

    public function afficher(){
        $slug                    = $this->route["params"]["slug"];
        $this->vue->Recette      = Recette::getFromSlug($slug);
        $this->vue->Commentaires = $this->vue->Recette->getCommentaires();
        $this->vue->afficher();
    }
}

 ?>
