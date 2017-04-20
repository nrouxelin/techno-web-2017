<?php

class Recette extends Modele{
    public $id, $nom, $texte, $lien_photo, $auteur;

    public static function getFromSlug($slug){
        $bdd = Bdd::getInstance();
        $sql = "SELECT
                      recettes.id as id,
                      recettes.nom as nom,
                      recettes.texte as texte,
                      recettes.lien_photo as lien_photo,
                      utilisateurs.nom as auteur
                FROM  recettes, utilisateurs
                WHERE slug = :slug AND recettes.auteur==utilisateurs.id ";
        $req = $bdd->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS, "Recette");
        $req->execute([":slug" => $slug]);
        return $req->fetch();
    }

    public function getCommentaires(){
        return Commentaire::getCommentairesFromRecette($this->id);
    }

    public function getFromCategorie($categorie){
        $bdd = Bdd::getInstance();
        $sql = "SELECT
                      recettes.nom as nom,
                      recettes.slug as slug
                FROM  recettes, recettes_categories
                WHERE recettes_categories.recette==recettes.id
                AND   recettes_categories.categorie==:categorie";

        $req = $bdd->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS,"Recette");
        $req->execute([":categorie" => $categorie]);
        return $req->fetchAll();
    }


}


 ?>
