<?php

class Recette extends Modele{
    public $id, $nom, $texte, $auteur, $slug, $validee;

    public static function getFromSlug($slug,$validee=true){
        $bdd = Bdd::getInstance();
        $sql = "SELECT
                      recettes.id      as id,
                      recettes.nom     as nom,
                      recettes.texte   as texte,
                      recettes.slug    as slug,
                      utilisateurs.nom as auteur
                FROM  recettes, utilisateurs
                WHERE slug = :slug AND recettes.auteur==utilisateurs.id";
        if($validee){//Si on ne veut que les recettes validées
            $sql = $sql." AND recettes.validee==1";
        }
        $req = $bdd->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS, "Recette");
        $req->execute([":slug" => $slug]);
        return $req->fetch();
    }

    public static function getFromAuteur($auteur){
        $bdd = Bdd::getInstance();
        $sql = "SELECT
                      recettes.id as id,
                      recettes.nom as nom,
                      recettes.texte as texte,
                      recettes.slug as slug,
                      utilisateurs.nom as auteur
                FROM  recettes, utilisateurs
                WHERE auteur==:auteur AND recettes.auteur==utilisateurs.id ";
        $req = $bdd->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS, "Recette");
        $req->execute([":auteur" => $auteur]);
        return $req->fetchAll();
    }

    public function getCommentaires(){
        return Commentaire::getCommentairesFromRecette($this->id);
    }

    public static function getFromCategorie($categorie){
        $bdd = Bdd::getInstance();
        $sql = "SELECT
                      recettes.nom as nom,
                      recettes.slug as slug
                FROM  recettes, recettes_categories
                WHERE recettes_categories.recette==recettes.id
                AND   recettes_categories.categorie==:categorie
                AND recettes.validee==1";

        $req = $bdd->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS,"Recette");
        $req->execute([":categorie" => $categorie]);
        return $req->fetchAll();
    }

    public static function lister($validee=true){
        $bdd = Bdd::getInstance();
        $sql = "SELECT nom, slug, validee FROM recettes ";
        if($validee){//Si on ne veut que les recettes validées
            $sql = $sql." WHERE recettes.validee==1 ORDER BY nom";
        }else{
            $sql = $sql." ORDER BY validee,nom";
        }
        $req = $bdd->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS,"Recette");
        $req->execute();
        return $req->fetchAll();
    }

    public static function ajouter($nom,$auteur,$categories,$texte){
        $bdd = Bdd::getInstance();
        //On ajoute la recette
        $slug = self::genererSlug($nom);
        $sql  = "INSERT INTO recettes(nom,auteur,texte,slug)
                VALUES (:nom,:auteur,:texte,:slug)";
        $req  = $bdd->prepare($sql);
        $req->execute([
                    ":nom"    => $nom,
                    ":auteur" => $auteur,
                    ":texte"  => $texte,
                    ":slug"   => $slug
                ]);
        $id = $bdd->lastInsertId();


        //On ajoute les catégories
        foreach($categories as $c){
            $sql = "INSERT INTO recettes_categories(recette,categorie)
                    VALUES (:recette,:categorie)";
            $req = $bdd->prepare($sql);
            $req->execute([
                ":recette"   => $id,
                ":categorie" => $c
            ]);
        }
    }


    public function valider(){
        $bdd = Bdd::getInstance();
        $sql = "UPDATE recettes SET validee=1 WHERE slug==:slug";
        $req = $bdd->prepare($sql);
        $req->execute([":slug" => $this->slug]);
    }

    public function supprimer(){
        $bdd = Bdd::getInstance();
        $sql = "DELETE FROM recettes WHERE slug==:slug";
        $req = $bdd->prepare($sql);
        $req->execute([":slug" => $this->slug]);
    }

}


 ?>
