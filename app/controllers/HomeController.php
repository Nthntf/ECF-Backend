<?php

namespace App\Controllers;

use App\controllers\BaseController;

class HomeController extends BaseController
{

    public function redirect()
    {
        header('Location: /home');
        exit;
    }

    public function index()
    {
        $this->render('home.html.twig', ['title' => 'Accueil', 'modal' => false]);
    }
}
