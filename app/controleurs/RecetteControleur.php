<?php
class RecetteControleur extends Controleur{

    public function afficher(){
        //On récupère la recette
        $slug                    = $this->route["params"]["slug"];
        $this->vue->Recette      = Recette::getFromSlug($slug);
        $this->vue->Commentaires = $this->vue->Recette->getCommentaires();

        //Construction du formulaire pour les commentaires
        $action     = Router::obtenirRoute("Commentaire","poster");
        $formulaire = new Formulaire($action,"post");
        $formulaire->ajouterChamp("number","note","Note :");
        $formulaire->ajouterChamp("textarea","texte","Votre commentaire :");
        $formulaire->ajouterChamp("submit","submit","Envoyer");
        $this->vue->Formulaire = $formulaire;

        //On affiche
        $this->vue->setTitre($this->vue->Recette->nom);
        $this->vue->afficher();
    }


}

 ?>
