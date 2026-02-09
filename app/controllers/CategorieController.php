<?php

namespace App\Controllers;

use App\controllers\BaseController;
use App\models\CategorieModel;
use PDOException;

class CategorieController extends BaseController
{
    public function index()
    {
        $categorieModel = new CategorieModel;
        $categories = $categorieModel->getAllCategories();
        $this->render('categorie.html.twig', ['title' => 'Les categories', 'categories' => $categories, 'role' => $_SESSION['user']['role'], 'modal' => true]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /categories');
            exit;
        }

        if (empty($_POST['nom'])) {
            $_SESSION['error'] = "Le nom de la catégorie est obligatoire";
            header('Location: /categories');
            exit;
        }

        $nom = trim($_POST['nom']);


        try {
            $categorieModel = new CategorieModel();
            $categorieModel->addCategorie($nom);

            $_SESSION['success'] = "Catégorie ajoutée avec succès";
        } catch (\RuntimeException $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: /categories');
        exit;
    }

    public function update(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /categories');
            exit;
        }

        if (empty($_POST['nom'])) {
            $_SESSION['error'] = "Le nom de la catégorie est obligatoire";
            header('Location: /categories');
            exit;
        }

        $nom = trim($_POST['nom']);

        try {
            $categorieModel = new CategorieModel();
            $categorieModel->updateCategorie($id, $nom);
        } catch (\RuntimeException $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: /categories');
        exit;
    }

    public function delete(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /categories');
            exit;
        }

        try {
            $categorieModel = new CategorieModel();
            $categorieModel->deleteCategorie($id);
        } catch (\RuntimeException $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: /categories');
        exit;
    }
}
