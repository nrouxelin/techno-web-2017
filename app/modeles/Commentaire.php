<?php

class Commentaire extends Modele{
    public $id, $note, $texte, $auteur;

    public static function getCommentairesFromRecette($recette_id){
        $bdd = Bdd::getInstance();
        $sql = "SELECT
                    commentaires.id as id,
                    commentaires.note as note,
                    commentaires.texte as texte,
                    utilisateurs.nom as auteur
                FROM commentaires, utilisateurs
                WHERE commentaires.recette==:recette_id
                AND utilisateurs.id==commentaires.auteur";
        $req = $bdd->prepare($sql);
        $req->setFetchMode(PDO::FETCH_CLASS,"Commentaire");
        $req->execute([":recette_id" => $recette_id]);
        return $req->fetchAll();
    }
}


 ?>
