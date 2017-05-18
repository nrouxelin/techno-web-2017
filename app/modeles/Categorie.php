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

    public static function supprimer($id){
        $bdd = Bdd::getInstance();
        $sql = "DELETE FROM categories WHERE id==:id";
        $req = $bdd->prepare($sql);
        $req->execute([":id" => $id]);
    }

    public static function ajouter($nom,$description){
        $bdd  = Bdd::getInstance();
        $slug = self::genererSlug($nom);
        $sql  = "INSERT INTO categories(nom,description,slug) VALUES (:nom,:description,:slug)";
        $req  = $bdd->prepare($sql);
        $req->execute([":nom" => $nom, ":description" => $description, ":slug" => $slug]);
    }
}

 ?>
