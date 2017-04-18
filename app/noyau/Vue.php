<?php

class Vue{
    protected $route;
    protected $data = [];

    public function __construct($route){
        $this->route = $route;
    }

    public function afficher(){
        var_dump($this->data);
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
