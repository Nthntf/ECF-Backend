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

        $auteurs = [];

        foreach ($authors as $author) {
            $auteurs[] = [
                'id' => $author['id'],
                'prenom' => $author['prenom'],
                'nom' => $author['nom'],
                'biographie' => $parsedown->text($author['biographie'])
            ];
        }

        $this->render('author.html.twig', [
            'title' => 'Les auteurs',
            'auteurs' => $auteurs,
            'modal' => true
        ]);
    }
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /authors');
            exit;
        }

        if (
            empty($_POST['nom']) ||
            empty($_POST['prenom']) ||
            empty($_POST['biographie'])
        ) {
            $_SESSION['error'] = "Tous les champs sont obligatoires";
            header('Location: /authors');
            exit;
        }

        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $biographie = trim($_POST['biographie']);

        try {
            $authorModel = new AuthorModel();
            $authorModel->addAuthor($nom, $prenom, $biographie);

            $_SESSION['success'] = "Auteur ajouté avec succès";
        } catch (\RuntimeException $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: /authors');
        exit;
    }

    public function update(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /authors');
            exit;
        }

        if (
            empty($_POST['nom']) ||
            empty($_POST['prenom']) ||
            empty($_POST['biographie'])
        ) {
            $_SESSION['error'] = "Tous les champs sont obligatoires";
            header('Location: /authors');
            exit;
        }

        $nom        = trim($_POST['nom']);
        $prenom     = trim($_POST['prenom']);
        $biographie = trim($_POST['biographie']);

        try {
            $authorModel = new AuthorModel();
            $authorModel->updateAuthor($id, $nom, $prenom, $biographie);

            $_SESSION['success'] = "Auteur modifié avec succès";
        } catch (\RuntimeException $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: /authors');
        exit;
    }

    public function delete(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /authors');
            exit;
        }

        try {
            $authorModel = new AuthorModel();
            $authorModel->deleteAuthor($id);

            $_SESSION['success'] = "Auteur supprimé avec succès";
        } catch (\RuntimeException $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: /authors');
        exit;
    }
}
