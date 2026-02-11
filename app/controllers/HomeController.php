<?php

namespace App\Controllers;

use App\controllers\BaseController;

class HomeController extends BaseController
{
    public function redirect()
    {
        // Redirige la route racine vers /home
        header('Location: /home');
        exit;
    }

    public function index()
    {
        // Affiche la page d'accueil
        $this->render('home.html.twig', [
            'title' => 'Accueil',
            'modal' => false
        ]);
    }
}
