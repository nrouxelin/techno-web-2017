<?php

class Vue{
    protected $route;
    protected $data = [];

    public function __construct($route){
        $this->route = $route;
    }

    //Affiche la vue correspondant au contrôleur et à l'action de la route
    public function afficher(){
        //Simplification de l'écriture
        $controleur  = $this->route["controleur"];
        $action      = $this->route["action"];
        $fichier_vue = ROOT."/app/vues/".$controleur."/".$action.".html";

        //Si le fichier à inclure existe
        if(file_exists($fichier_vue)){
            ob_start();//Tamporisation de la sortie
            $data      = $this->data;//Données à afficher
            $vue_titre = $data[$controleur]->nom;//Titre de la page

            include(ROOT."/app/vues/haut.html");//Header
            include($fichier_vue);//Contenu de la page
            include(ROOT."/app/vues/bas.html");//Footer

            $contenu = ob_get_clean();//On récupère la sortie
            echo $contenu;//On affiche
        }else{//Le fichier n'existe pas
            throw new DomainException("Vue introuvable : ".$fichier_vue);
        }

    }

    //Méthodes magiques
    public function __set($cle, $valeur){
        $this->data[$cle] = $valeur;
    }

    public function __get($cle){
        return $this->data[$cle];
    }
}

 ?>
