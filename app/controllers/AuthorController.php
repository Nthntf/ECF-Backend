<?php

namespace App\Controllers;

use App\controllers\BaseController;

class AuthorController extends BaseController
{
    public function index()
    {
        $this->render('author.html.twig', ['title' => 'Les auteurs', 'modal' => true]);
    }
}
