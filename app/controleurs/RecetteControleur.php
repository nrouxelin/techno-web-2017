<?php
class RecetteControleur extends Controleur{

    public function afficher(){

        //On récupère la recette
        $slug     = $this->route["params"]["slug"];
        $recette  = Recette::getFromSlug($slug);
        $action   = Router::obtenirRoute("Recette","afficher",$slug);

        //Si le formulaire a déjà été posté
        if(Utilisateur::estConnecte() && isset($_POST["note"]) && isset($_POST["texte"])){
            $note  = htmlspecialchars($_POST["note"]);
            $texte = htmlspecialchars($_POST["texte"]);

            Commentaire::ajouter($note,$texte,$recette->id);
            header("Location:".$action);
        }

        //Construction du formulaire pour les commentaires
        $formulaire = new Formulaire($action,"post");
        $formulaire->ajouterChamp("number","note","Note :");
        $formulaire->ajouterChamp("textarea","texte","Votre commentaire :");
        $formulaire->ajouterChamp("submit","submit","Envoyer");
        $this->vue->Formulaire = $formulaire;

        //On affiche
        $this->vue->Recette      = $recette;
        $this->vue->Commentaires = $recette->getCommentaires();
        $this->vue->setTitre($recette->nom);
        $this->vue->afficher();
    }


}

 ?>
