<?php

namespace App\Controllers;

use App\controllers\BaseController;
use App\models\AuthorModel;
use Parsedown;

class AuthorController extends BaseController
{
    public function index()
    {
        $authorModel = new AuthorModel();
        $authors = $authorModel->getAllAuthors();

        $parsedown = new Parsedown();

        $biographies = [];

        foreach ($authors as $author) {
            $biographies[] = [
                'id' => $author['id'],
                'name' => $author['name'],
                'biographie' => $parsedown->text($author['biographie'])
            ];
        }

        $this->render('author.html.twig', ['title' => 'Les auteurs', 'biographies' => $biographies, 'modal' => true]);
    }
}
