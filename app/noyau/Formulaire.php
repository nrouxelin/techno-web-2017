<?php

class Formulaire{
    protected $action, $methode;
    protected $champs=[];
    protected $valeurs=[];

    public function __construct($action, $methode){
        $this->action  = $action;
        $this->methode = $methode;
        $this->valeurs = isset($_POST) ? $_POST : [];
    }

    public function ajouterChamp($type, $nom, $label){
        if(array_key_exists($nom, $this->champs)){
            throw new Exception("Un champ nommé ".$nom." existe déjà.");
        }else{
            $this->champs[$nom] = [
                "type"   => $type,
                "label"  => $label,
            ];
        }

    }

    public function afficherFormulaire(){
        echo '<form action="'.$this->action.'" method="'.$this->methode.'">';
        foreach($this->champs as $n=>$c){
            $val = (isset($this->valeurs[$n]) && !empty($this->valeurs[$n])) ? $this->valeurs[$n] : '';
            if($c["type"]==="textarea"){
                echo '<label for="'.$n.'">'.$c["label"].'</label><br/>';
                echo '<textarea name="'.$n.'" id="'.$n.'">'.$val.'</textarea>';
            }else{
                if($c["type"]!="submit"){
                    echo '<label for="'.$n.'">'.$c["label"].'</label>';
                }else{
                    $val = $c["label"];
                }
                echo '<input type="'.$c["type"].'" name="'.$n.'" value="'.$val.'" id="'.$n.'" /><br />';
            }
        }
        echo '</form>';
    }


}

 ?>
