<?php

namespace App\Controllers;

use App\controllers\BaseController;

class BookController extends BaseController
{
    public function index()
    {
        $this->render('book.html.twig', ['title' => 'Bibliothèque de livres', 'modal' => true]);
    }
}
