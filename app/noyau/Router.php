<?php

class Router{
    public static function analyser($req){
        $resultat = [
            "controleur" => "Erreur",
            "action"     => "erreur404",
            "params"     => []
        ];

        if($req==="" || $req==="/"){
            $resultat["controleur"] = "Index";
            $resultat["action"]     = "afficher";
        }else{
            $parties = explode("/",$req);
            $nb_parties = count($parties);
            if($nb_parties==3){
                $resultat["controleur"]     = $parties[0];
                $resultat["action"]         = $parties[1];
                $resultat["params"]["slug"] = $parties[2];
            }
        }

        return $resultat;
    }
}

 ?>
