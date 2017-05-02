<?php

class Bdd{
    protected static $_instance = null;
    protected $_bdd;

    protected function __construct(){
        //On initialise PDO pour la bdd SQLite
        try{
            $this->_bdd = new PDO('sqlite:'.ROOT.'/app/bdd/db.sqlite');
            $this->_bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(Exception $e){
            echo "Impossible d'accéder à la base de données SQLite : ".$e->getMessage();
            die();
        }
    }

    public static function getInstance(){
        //Implémentation du design patern Singleton : on appelle toujours la même
        //instance de PDO
        if(is_null(self::$_instance))
            self::$_instance = new Bdd();
        return self::$_instance;
    }

    public function __call($methode, array $arg){
        //Si on appelle une méthode qui n'existe pas, on la délègue à l'objet PDO
        return call_user_func_array([$this->_bdd,$methode], $arg);
    }

}

 ?>
