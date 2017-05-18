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

    public static function ajouter($note,$texte,$recette_id){
        $bdd = Bdd::getInstance();
        $sql = "INSERT INTO commentaires(note,texte,recette,auteur)
                VALUES (:note,:texte,:recette,:auteur)";
        $req = $bdd->prepare($sql);
        $req->execute([
            ":note"    => $note,
            ":texte"   => $texte,
            ":recette" => $recette_id,
            ":auteur"  => $_SESSION["id"]
        ]);
    }

    public static function supprimer($id){
        if(!Utilisateur::estAdmin()){
            header("Location: ".Router::obtenirRoute("Erreur","erreur403"));
        }else{
            $bdd = Bdd::getInstance();
            $sql = "DELETE FROM commentaires WHERE id==:id";
            $req = $bdd->prepare($sql);
            $req->execute([":id" => $id]);
        }
    }
}


 ?>
