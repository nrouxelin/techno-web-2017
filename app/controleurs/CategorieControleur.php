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
}

 ?>
