<?php

class Utilisateur extends Modele{
    public $id, $nom, $email, $admin;

    public static function existe($nom){
        $bdd = Bdd::getInstance();
        $sql = "SELECT id FROM utilisateurs WHERE nom==:nom";
        $req = $bdd->prepare($sql);
        $req->setFetchMode(PDO::FETCH_NUM);
        $req->execute([":nom" => $nom]);
        if(!$req->fetch()){
            return false;
        }else{
            return true;
        }
    }

    public static function emailUtilise($email){
        $bdd = Bdd::getInstance();
        $sql = "SELECT id FROM utilisateurs WHERE email==:email";
        $req = $bdd->prepare($sql);
        $req->setFetchMode(PDO::FETCH_NUM);
        $req->execute([":email" => $email]);
        if(!$req->fetch()){
            return false;
        }else{
            return true;
        }
    }

    public static function ajouter($nom, $mot_passe, $email){
        $bdd = Bdd::getInstance();
        $sql = "INSERT INTO utilisateurs(nom,email,mot_passe) VALUES (:nom, :email, :mot_passe)";
        $req = $bdd->prepare($sql);
        $req->execute([":nom" => $nom, ":email" => $email, ":mot_passe" => sha1($mot_passe)]);
    }

    public static function identifier($nom, $mot_passe){
        $bdd = Bdd::getInstance();
        $sql = "SELECT id, nom, email, admin FROM utilisateurs WHERE nom==:nom AND mot_passe==:mot_passe";
        $req = $bdd->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS,"Utilisateur");
        $req->execute([":nom" => $nom, ":mot_passe" => sha1($mot_passe)]);
        return $req->fetch();
    }

    public static function estConnecte(){
        return !empty($_SESSION['id']);
    }

    public static function estAdmin(){
        return (self::estConnecte())&&($_SESSION['admin']);
    }

    public static function lister(){
        $bdd = Bdd::getInstance();
        $sql = "SELECT id,nom FROM utilisateurs ORDER BY nom";
        $req = $bdd->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS,"Utilisateur");
        $req->execute();
        return $req->fetchAll();
    }

    public static function getFromId($id){
        $bdd = Bdd::getInstance();
        $sql = "SELECT id,nom FROM utilisateurs WHERE id=:id";
        $req = $bdd->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS,"Utilisateur");
        $req->execute([":id" => $id]);
        return $req->fetch();
    }

    public function supprimer(){
        $bdd = Bdd::getInstance();
        $sql = "DELETE FROM utilisateurs WHERE id==:id";
        $req = $bdd->prepare($sql);
        $req->execute([":id" => $this->id]);
    }
}

 ?>
