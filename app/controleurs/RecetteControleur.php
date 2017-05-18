<?php
class RecetteControleur extends Controleur{
        public static $extensions = ['jpg','jpeg','png'];

    public function afficher(){

        //Les admin peuvent afficher les recettes non validées
        if(Utilisateur::estAdmin()){
            $valide = false;
        }else{
            $valide = true;
        }

        //On récupère la recette
        $slug     = $this->route["params"]["slug"];
        $recette  = Recette::getFromSlug($slug,$valide);
        $action   = Router::obtenirRoute("Recette","afficher",$slug);

        if(!$recette){//Si la recette n'existe pas
            header("Location: ".Router::obtenirRoute("Erreur","erreur404"));
        }

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

        //On récupère l'image
        foreach(self::$extensions as $e){
            if(file_exists(ROOT."/www/images/".$recette->id.".".$e)){
                $image = DIR_IMG.$recette->id.'.'.$e;
                break;
            }
        }

        //On affiche
        $this->vue->Recette      = $recette;
        $this->vue->Commentaires = $recette->getCommentaires();
        $this->vue->Image        = $image;
        $this->vue->setTitre($recette->nom);
        $this->vue->afficher();
    }


    public function lister(){
        //On récupère les recettes
        $recettes = Recette::lister();

        //On envoie à la vue
        $this->vue->Recettes = $recettes;
        $this->vue->setTitre("Liste des recettes");
        $this->vue->afficher();
    }


    public function mes_recettes(){
        //On vérifie si l'utilisateur est connecté
        if(!Utilisateur::estConnecte()){
            header("Location: ".Router::obtenirRoute("Erreur","erreur403"));
        }

        //On récupère les recettes
        $recettes = Recette::getFromAuteur($_SESSION["id"]);

        //On envoie à la vue
        $this->vue->Recettes = $recettes;
        $this->vue->setTitre("Mes recettes");
        $this->vue->afficher();
    }

    public function ajouter(){
        //Si l'utilisateur n'est pas connecté
        if(!Utilisateur::estConnecte()){
            header("Location: ".Router::obtenirRoute("Erreur","erreur403"));
        }

        //On récupère les catégories
        $categories = Categorie::lister();

        //Si le formulaire a déjà été envoyé
        if(isset($_POST) && !empty($_POST)){
            $nom    = $_POST["titre"];
            $auteur = $_SESSION["id"];

            //Catégories de la recette
            $cat = [];
            foreach($categories as $c){
                if(isset($_POST[$c->id])){
                    $cat[] = $c->id;
                }
            }

            $ingredients  = $this->transformerChaineListe($_POST["ingredients"]);
            $explications = $this->transformerChaineListe($_POST["explications"],true);
            $texte = "<h3>Ingrédients :</h3><p>".$ingredients."</p>
                    <h3>Préparation de la recette :</h3><p>".$explications."</p>";


            //On ajoute la recette dans la bdd
            $id = Recette::ajouter($nom,$auteur,$cat,$texte);


            //Gestion de l'image
            //Vérification de l'extension
            $extension_upload = strtolower(substr(strrchr($_FILES['image']['name'],'.'),1));
            if (!in_array($extension_upload,self::$extensions)) header("Location: ".Router::obtenirRoute("Recette","ajouter"));
            $nom_img = ROOT."/www/images/".$id.".".$extension_upload;
            $res     = move_uploaded_file($_FILES["image"]["tmp_name"],$nom_img);

            //Redirection
            header("Location: ".Router::obtenirRoute("Recette","succes"));
        }



        //Construction du formulaire
        $action     = Router::obtenirRoute("Recette","ajouter");
        $formulaire = new Formulaire($action,"post",true);
        $formulaire->ajouterChamp("input","titre","Titre de la recette");
        //Catégories
        $formulaire->ajouterChamp("hidden","separateur","Catégories de la recette :");
        foreach($categories as $c){
            $formulaire->ajouterChamp("checkbox",$c->id,$c->nom,false);
        }
        $formulaire->ajouterChamp("textarea","ingredients","Ingrédients de la recette :");
        $formulaire->ajouterChamp("textarea","explications","Texte de la recette : ");
        $formulaire->ajouterChamp("file","image","Photo de la recette :");
        $formulaire->ajouterChamp("submit","submit","Ajouter ma recette");

        //Création de la vue
        $this->vue->Formulaire = $formulaire;
        $this->vue->setTitre("Ajouter une recette.");
        $this->vue->afficher();
    }

    private function transformerChaineListe($chaine,$numerotation=false){
        if($numerotation){
            $debut = "<ol><li>";
            $fin   = "</li></ol>";
        }else{
            $debut = "<ul><li>";
            $fin   = "</li></ul>";
        }
        $chaine = str_replace("\n","</li><li>",$chaine);
        $chaine = $debut.$chaine.$fin;
        return $chaine;
    }

    public function gerer(){
        //Si l'utilisateur n'est pas administrateur
        if(!Utilisateur::estAdmin()){
            header("Location: ".Router::obtenirRoute("Erreur","erreur403"));
        }

        //On récupère les recettes
        $recettes = Recette::lister(false);

        //On envoie à la vue
        $this->vue->Recettes = $recettes;
        $this->vue->setTitre("Gestion des recettes");
        $this->vue->afficher();
    }

    public function valider(){
        //Si l'utilisateur n'est pas administrateur
        if(!Utilisateur::estAdmin()){
            header("Location: ".Router::obtenirRoute("Erreur","erreur403"));
        }

        //On récupère la recette
        $slug    = $this->route["params"]["slug"];
        $recette = Recette::getFromSlug($slug,false);

        //Si la recette n'existe pas
        if(!$recette){
            header("Location: ".Router::obtenirRoute("Recette","gerer"));
        }

        $recette->valider();
        header("Location: ".Router::obtenirRoute("Recette","gerer"));
    }

    public function supprimer(){
        //Si l'utilisateur n'est pas administrateur
        if(!Utilisateur::estAdmin()){
            header("Location: ".Router::obtenirRoute("Erreur","erreur403"));
        }

        //On récupère la recette
        $slug    = $this->route["params"]["slug"];
        $recette = Recette::getFromSlug($slug,false);

        //Si la recette n'existe pas
        if(!$recette){
            header("Location: ".Router::obtenirRoute("Recette","gerer"));
        }

        $recette->supprimer();
        header("Location: ".Router::obtenirRoute("Recette","gerer"));
    }

    public function succes(){
        $this->vue->setTitre("Succès");
        $this->vue->afficher();
    }

}

 ?>
