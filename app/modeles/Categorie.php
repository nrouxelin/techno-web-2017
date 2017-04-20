<?php

class Categorie extends Modele{
    public $id, $nom, $slug, $description;

    public static function lister(){
        $bdd = Bdd::getInstance();
        $sql = "SELECT id, nom, slug FROM categories";
        $req = $bdd->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS,"Categorie");
        $req->execute();
        return $req->fetchAll();
    }

    public static function getFromSlug($slug){
        $bdd = Bdd::getInstance();
        $sql = "SELECT id, nom, slug, description
                FROM categories
                WHERE slug==:slug";
        $req = $bdd->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS,"Categorie");
        $req->execute([":slug" => $slug]);
        return $req->fetch();
    }
}

 ?>
