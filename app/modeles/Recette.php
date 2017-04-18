<?php

class Recette extends Modele{
    public $id, $nom, $auteur, $slug, $texte, $lien_photo;

    public static function getFromSlug($slug){
        $bdd = Bdd::getInstance();
        $sql = "SELECT * FROM recettes WHERE slug = :slug";
        $req = $bdd->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS, "Recette");
        $req->execute([":slug" => $slug]);
        return $req->fetch();
    }



}


 ?>
