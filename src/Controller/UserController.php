<?php
//classe qui représente les entrées et sorties GET et POST
namespace App\Controller;

//Import des dépendances
use App\Service\UserService;
use App\Controller\AbstractController;

class UserController extends AbstractController
{
    private UserService $userService;

    public function __construct() 
    {
        $this->userService = new UserService();
    }

    public function register(): mixed
    {

        //Test si le formulaire est soumis
        if (isset($_POST["submit"])) {
            //Appel de la logique de création du compte
            $data["msg"] = $this->userService->addUser();
        }

        //Affichage du template
        return $this->render('register', 'Inscription', $data ?? []);
    }

    //Méthode pour se connecter
    public function login(): mixed
    {
        //Test si le formulaire est soumis
        if (isset($_POST["submit"])) {
            //Appel de la la logique de connexion
            $data["msg"] = $this->userService->connection();
        }

        //Affichage du template
        return $this->render('login', 'Connexion', $data ?? []);
    }
}
