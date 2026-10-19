<?php
//classe qui représente la logique métier (Algo)
namespace App\Service;

//Imports des dépendances
use App\Entity\User;
use App\Repository\UserRepository;
use App\Utils\Tools;

class UserService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function addUser(): string 
    {
        //tester si les champs sont remplis
        if (
            empty($_POST["firstname"]) ||
            empty($_POST["lastname"]) ||
            empty($_POST["email"]) ||
            empty($_POST["password"]) ||
            empty($_POST["confirm-password"]) 
        ) {
            return "Veuillez remplir tous les champs";
        }

        //nettoyer les données
        Tools::sanitizeArray($_POST);
        
        //vérifier si les 2 mots de passe sont identiques
        if ($_POST["password"] != $_POST["confirm-password"]) {
            return "Les 2 mots de passe ne sont pas identiques";
        }

        //test si le mot de passe est trop court
        if(strlen($_POST["password"]) < 8 ) {
            return "Le mot de passe doit avoir au moins 8 caractéres";
        }

        //Récupération du compte
        $user =  $this->userRepository->findByEmail($_POST["email"]);
        
        //vérifier si le compte existe déja
        if ($user) {
            return "Le compte existe déja";
        }
        
        //hasher le mot de passe
        $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
        
        //hydater en objet la super globale POST
        $newUser = User::hydrate($_POST);
        
        //Setter le hash à l'objet User
        $newUser->setPassword($hash);
        
        //ajouter en BDD le compte User
        $this->userRepository->create($newUser);
        
        //Message de confirmation
        return "Le compte " . $_POST["email"] . " a été ajouté en BDD";
    }

    public function connection(): string 
    {

        //tester si les champs sont remplis
        if (
            empty($_POST["email"]) ||
            empty($_POST["password"])
        ) {
            return "Veuillez remplir tous les champs";
        }

        //nettoyer les données
        Tools::sanitizeArray($_POST);
        
        //Récupération du compte
        $user =  $this->userRepository->findByEmail($_POST["email"]);
        
        //vérifier si le compte n'existe pas
        if ($user == null) {
            return "Les informations de connexion sont incorrecte";
        }
        
        //vérifier si le mot de passe n'est compatible
        if (!password_verify($_POST["password"], $user->getPassword())) {
            return "Les informations de connexion sont incorrecte";
        }

        //créer les super globale de session
        $_SESSION["firstname"] = $user->getFirstname();
        $_SESSION["lastname"] = $user->getLastname();
        $_SESSION["id"] = $user->getId();
        $_SESSION["connected"] = true;

        //Message de confirmation
        return "User connecté";
    }
}
