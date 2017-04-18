<?php

class Controleur{
    protected $route;
    protected $vue;

    public function __construct($route){
        $this->route = $route;
        $this->vue = new Vue($route);
    }
}

 ?>
