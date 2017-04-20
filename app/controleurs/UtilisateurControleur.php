<?php

class UtilisateurControleur extends Controleur{

    public function s_inscrire(){
        //Si l'utilisateur est déjà connecté
        if(Utilisateur::estConnecte()){
            header("Location: ".WEB_ROOT);
        }
        //Si le formulaire a déjà été envoyé
        if(isset($_POST["nom"]) && isset($_POST["mot_passe"]) &&
            isset($_POST["confirmation"]) && isset($_POST["email"])){
                $erreurs = [];
                $data = $_POST;
                if($data["mot_passe"]===$data["confirmation"]){
                    if(Utilisateur::existe($data["nom"])){
                        $erreurs["nom"] = "Cet utilisateur existe déjà.";
                    }else{
                        if(Utilisateur::emailUtilise($data["email"])){
                            $erreurs["email"] = "Cette adresse email est déjà utilisée.";
                        }else{
                            Utilisateur::ajouter($data["nom"], $data["mot_passe"], $data["email"]);
                        }
                    }
                }else{
                    $erreurs["mot_passe"] = "Le mot de passe et la confirmation sont différents.";
                }
            }


        //Création du formulaire
        $action     = Router::obtenirRoute("Utilisateur","s_inscrire");
        $formulaire = new Formulaire($action,"post");
        $formulaire->ajouterChamp("input","nom","Votre nom :");
        $formulaire->ajouterChamp("password","mot_passe","Votre mot de passe :");
        $formulaire->ajouterChamp("password","confirmation","Confirmez :");
        $formulaire->ajouterChamp("email","email","Votre adresse email :");
        $formulaire->ajouterChamp("submit","submit","S'inscrire");

        //On envoie tout à la vue
        $this->vue->Formulaire = $formulaire;
        $this->vue->setTitre("Inscription");
        $this->vue->Erreurs = $erreurs;
        $this->vue->afficher();
    }

    public function se_connecter(){
        //Si l'utilisateur est déjà connecté
        if(Utilisateur::estConnecte()){
            header("Location: ".WEB_ROOT);
        }
        //Si le formulaire a déjà été posté
        if(isset($_POST["nom"]) && isset($_POST["mot_passe"])){
            $erreurs;
            $nom       = $_POST["nom"];
            $mot_passe = $_POST["mot_passe"];

            $utilisateur = Utilisateur::identifier($nom,$mot_passe);
            if(!$utilisateur){
                $erreurs["mot_passe"] = "Nom d'utilisateur ou mot de passe incorrect.";
            }else{
                $_SESSION["id"]    = $utilisateur->id;
                $_SESSION["nom"]   = $nom;
                $_SESSION["email"] = $utilisateur->email;
                $_SESSION["admin"] = $utilisateur->admin;
                header("Location: ".WEB_ROOT);
            }
        }

        //Création du formulaire
        $action     = Router::obtenirRoute("Utilisateur","se_connecter");
        $formulaire = new Formulaire($action,"post");
        $formulaire->ajouterChamp("input","nom","Votre nom :");
        $formulaire->ajouterChamp("password","mot_passe","Votre mot de passe :");
        $formulaire->ajouterChamp("submit","submit","Se connecter");

        //vue
        $this->vue->Formulaire = $formulaire;
        $this->vue->Erreurs    = $erreurs;
        $this->vue->setTitre("Connexion");
        $this->vue->afficher();
    }

    public function se_deconnecter(){
        $_SESSION = [];
        session_destroy();
        header("Location: ".WEB_ROOT);
    }


}

 ?>
