<?php

namespace App\Controller;

use App\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * Méthode pour afficher la page Accueil
     */
    public function accueil(): mixed 
    {
        return $this->render('home', 'Accueil');
    }

    public function conditionGenerale(): mixed
    {
        return $this->render('condition_generale', 'Conditions Générales');
    }
}
