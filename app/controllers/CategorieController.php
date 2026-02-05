<?php

namespace App\Controllers;

use App\controllers\BaseController;

class CategorieController extends BaseController
{
    public function index()
    {
        $this->render('categorie.html.twig', ['title' => 'Les categories']);
    }
}
