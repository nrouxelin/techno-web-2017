<?php

class CategorieControleur extends Controleur{

    public function afficher(){
        //On récupère la catégorie
        $slug      = $this->route["params"]["slug"];
        $categorie = Categorie::getFromSlug($slug);

        //On récupère les recettes de la catégorie
        $recettes = Recette::getFromCategorie($categorie->id);

        //Génération de la vue
        $this->vue->setTitre($categorie->nom);
        $this->vue->Categorie = $categorie;
        $this->vue->Recettes  = $recettes;
        $this->vue->afficher();
    }

    public function lister(){
        $categories = Categorie::lister();

        $this->vue->Categories = $categories;
        $this->vue->setTitre("Liste des catégories");
        $this->vue->afficher();
    }

    public function gerer(){
        //Si l'utilisateur n'est pas administrateur
        if(!Utilisateur::estAdmin()){
            header("Location: ".Router::obtenirRoute("Erreur","erreur403"));
        }


        $categories = Categorie::lister();

        //Si le formulaire a été envoyé
        if(isset($_POST) && !empty($_POST)){
            Categorie::ajouter($_POST["nom"],$_POST["description"]);
            header("Location: ".Router::obtenirRoute("Categorie","gerer"));
        }


        //Préparation du formulaire
        $action = Router::obtenirRoute("Categorie","gerer");
        $formulaire = new Formulaire($action,"POST");
        $formulaire->ajouterChamp("input","nom","Nom de la catégorie");
        $formulaire->ajouterChamp("textarea","description","Description de la catégorie");
        $formulaire->ajouterChamp("submit","submit","Ajouter une catégorie");

        //Generation de la vue
        $this->vue->Categories = $categories;
        $this->vue->Formulaire = $formulaire;
        $this->vue->setTitre("Gestion des categories");
        $this->vue->afficher();
    }

    public function supprimer(){
        if(!Utilisateur::estAdmin()){
            header("Location: ".Router::obtenirRoute("Erreur","erreur403"));
        }

        //On supprimer la catégorie
        $id = $this->route["params"]["slug"];
        Categorie::supprimer($id);
        header("Location: ".Router::obtenirRoute("Categorie","gerer"));
    }
}

 ?>
