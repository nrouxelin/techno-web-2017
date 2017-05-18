<?php

class CommentaireControleur extends Controleur{

    public function supprimer(){
        $id = $this->route["params"]["slug"];
        if(!Utilisateur::estAdmin()){//Si l'utilisateur n'est pas admin
            header("Location: ".Router::obtenirRoute("Erreur","erreur403"));
        }else{
            $recette_slug = Recette::getRecetteFromCommentaire($id)->slug;
            Commentaire::supprimer($id);
            header("Location: ".Router::obtenirRoute("Recette","afficher",$recette_slug));
        }
    }
}

 ?>
