<?php

class Noyau{


    public static function autoload($classe){
        if(file_exists(ROOT."/app/noyau/$classe.php"))
            require_once(ROOT."/app/noyau/$classe.php");
        else if(file_exists(ROOT."/app/controleurs/$classe.php"))
            require_once(ROOT."/app/controleurs/$classe.php");
        else if(file_exists(ROOT."/app/modeles/$classe.php"))
            require_once(ROOT."/app/modeles/$classe.php");
    }

    public static function lancer(){
        //Autoload
        spl_autoload_register(["Noyau", "autoload"]);

        //Requête
        $req   = isset($_GET['req']) ? $_GET['req'] : '';
        $route = Router::analyser($req);

        //Instancier le controleur et effectuer l'action
        $classe = $route["controleur"]."Controleur";

        $erreur = true;

        if(class_exists($classe)){
            $controleur = new $classe ($route);
            $methode = [$controleur, $route['action']];
            if(is_callable($methode)){
                call_user_func($methode);
                $erreur = false;
            }
        }

        //Gestion des erreurs
        if($erreur){
            throw new Exception("Controleur ou action inconnue");
        }


    }
}

 ?>
