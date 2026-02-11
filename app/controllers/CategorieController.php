<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategorieModel;

class CategorieController extends BaseController
{
    public function index()
    {
        // Récupère toutes les catégories
        $categorieModel = new CategorieModel();
        $categories = $categorieModel->getAllCategories();

        $this->render('categorie.html.twig', [
            'title'      => 'Les catégories',
            'categories' => $categories,
            'modal'      => true
        ]);
    }

    public function add()
    {
        // Autorise uniquement les requêtes POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /categories');
            exit;
        }

        // Validation du champ obligatoire
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
            // Stocke l'erreur pour affichage
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

            $_SESSION['success'] = "Catégorie modifiée avec succès";
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

            $_SESSION['success'] = "Catégorie supprimée avec succès";
        } catch (\RuntimeException $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: /categories');
        exit;
    }
}
