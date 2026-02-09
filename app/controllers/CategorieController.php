<?php

namespace App\Controllers;

use App\controllers\BaseController;
use App\models\CategorieModel;

class CategorieController extends BaseController
{
    public function index()
    {
        $categorieModel = new CategorieModel;
        $categories = $categorieModel->getAllCategories();
        $this->render('categorie.html.twig', ['title' => 'Les categories', 'categories' => $categories, 'role' => $_SESSION['user']['role'], 'modal' => true]);
    }
}
