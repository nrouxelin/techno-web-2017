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

    public function ajouterChamp($type, $nom, $label, $requis=true){
        if(array_key_exists($nom, $this->champs)){
            throw new Exception("Un champ nommé ".$nom." existe déjà.");
        }else{
            $this->champs[$nom] = [
                "type"   => $type,
                "label"  => $label,
                "requis" => $requis
            ];
        }

    }

    public function afficherFormulaire(){
        echo '<form action="'.$this->action.'" method="'.$this->methode.'">';
        foreach($this->champs as $n=>$c){
            $val = (isset($this->valeurs[$n]) && !empty($this->valeurs[$n])) ? $this->valeurs[$n] : '';
            if($c["type"]==="textarea"){
                echo '<p><label for="'.$n.'">'.$c["label"].'</label><br/>';
                echo '<textarea name="'.$n.'" id="'.$n.'">'.$val.'</textarea></p>';
            }else{
                if($c["type"]!="submit"){
                    echo '<p><label for="'.$n.'">'.$c["label"].'</label>';
                }else{
                    $val = $c["label"];
                }
                $requis = $c["requis"] ? 'required' : '';
                echo '<input type="'.$c["type"].'" name="'.$n.'" value="'.$val.'" id="'.$n.'"'.$requis.' /></p>';
            }
        }
        echo '</form>';
    }


}

 ?>
