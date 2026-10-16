<?php
include '../vendor/autoload.php';

//récupération de l'URL (composante)
$url = parse_url($_SERVER["REQUEST_URI"]);

//extraction du path
$path = isset($url["path"]) ? $url["path"] : "/";


//importer les variables d'environnement 
$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

//importer
use App\Controller\HomeController;
use App\Controller\UserController;

//instancier les controllers
$homeController = new HomeController();
$userController = new UserController();

//test des valeurs du path
switch ($path) {
    case '/':
        $homeController->accueil();
        break;
    case '/register':
        $userController->register();
        break;
    case '/profil':
        echo "Profil user";
        break;
    case '/login':
        $userController->login();
        break;
    default:
        echo "Erreur 404";
        break;
}
