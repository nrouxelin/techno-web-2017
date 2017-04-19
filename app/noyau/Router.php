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
            if($nb_parties==3 || $nb_parties==2){
                $resultat["controleur"]     = $parties[0];
                $resultat["action"]         = $parties[1];
                if($nb_parties==3)
                    $resultat["params"]["slug"] = $parties[2];
            }
        }

        return $resultat;
    }

    public static function obtenirRoute($controleur, $action, $params=""){
        return WEB_ROOT.$controleur."/".$action."/".$params;
    }
}

 ?>
