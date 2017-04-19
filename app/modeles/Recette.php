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
                FROM recettes, utilisateurs
                WHERE slug = :slug AND recettes.auteur==utilisateurs.id ";
        $req = $bdd->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS, "Recette");
        $req->execute([":slug" => $slug]);
        return $req->fetch();
    }

    public function getCommentaires(){
        return Commentaire::getCommentairesFromRecette($this->id);
    }


}


 ?>
