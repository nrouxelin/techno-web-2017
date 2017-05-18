<?php

class Modele{

    public static function genererSlug($chaine){
        setlocale(LC_CTYPE, 'fr_FR');//règle bug ? de iconv
        $res = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $chaine);//supprimer les caractères spéciaux
        $res = preg_replace('#[^.0-9a-z]+#i', '-', $res);//supprimer les accents
        $res = trim($res,'-');//supprimer les espace/tirets en début et fin de chaine
        $res = strtolower($res);//passer la chaine en minuscules

        return $res;
    }
}

 ?>
