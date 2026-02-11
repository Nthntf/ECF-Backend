<?php

namespace App\Controllers;

use App\controllers\BaseController;
use App\models\BookModel;
use App\models\AuthorModel;
use App\models\CategorieModel;

use Parsedown;

class BookController extends BaseController
{
    public function index()
    {
        $authorModel = new AuthorModel();
        $categoryModel = new CategorieModel();
        $bookModel = new BookModel();

        $auteurs = $authorModel->getAllAuthors();
        $categories = $categoryModel->getAllCategories();
        $books = $bookModel->getAllBooks();


        $parsedown = new Parsedown();
        $livres = [];

        foreach ($books as $book) {
            $livres[] = [
                'id' => $book['id'],
                'titre' => $book['titre'],
                'annee_publication' => $book['annee_publication'],
                'isbn' => $book['isbn'],
                'disponible' => $book['disponible'],
                'synopsis' => $parsedown->text($book['synopsis']),
                'is_liked' => $book['is_liked'],

                'auteur' => [
                    'id' => $book['auteur_id'],
                    'nom' => $book['auteur_nom'],
                    'prenom' => $book['auteur_prenom']
                ],

                'categorie' => [
                    'id' => $book['categorie_id'],
                    'nom' => $book['categorie_nom']
                ]
            ];
        }

        $this->render('book.html.twig', [
            'title' => 'Les livres',
            'livres' => $livres,
            'auteurs' => $auteurs,
            'categories' => $categories,
            'modal' => true
        ]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /books');
            exit;
        }

        if (
            empty($_POST['titre']) ||
            empty($_POST['auteur_id']) ||
            empty($_POST['categorie_id']) ||
            empty($_POST['annee_publication']) ||
            empty($_POST['isbn']) ||
            empty($_POST['synopsis'])
        ) {
            $_SESSION['error'] = "Tous les champs sont obligatoires";
            header('Location: /books');
            exit;
        }

        $titre = trim($_POST['titre']);
        $auteur_id = (int) $_POST['auteur_id'];
        $categorie_id = (int) $_POST['categorie_id'];
        $annee_publication = (int) $_POST['annee_publication'];
        $isbn = trim($_POST['isbn']);
        $synopsis = trim($_POST['synopsis']);
        $disponible = (int) $_POST['disponible'];
        $like = (int) $_POST['like'];

        try {
            $bookModel = new BookModel();
            $bookModel->addBook(
                $titre,
                $auteur_id,
                $categorie_id,
                $annee_publication,
                $isbn,
                $disponible,
                $synopsis,
                $like
            );

            $_SESSION['success'] = "Livre ajouté avec succès";
        } catch (\RuntimeException $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: /books');
        exit;
    }

    public function update(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /books');
            exit;
        }

        if (
            empty($_POST['titre']) ||
            empty($_POST['auteur_id']) ||
            empty($_POST['categorie_id']) ||
            empty($_POST['annee_publication']) ||
            empty($_POST['isbn']) ||
            empty($_POST['synopsis'])
        ) {
            $_SESSION['error'] = "Tous les champs sont obligatoires";
            header('Location: /books');
            exit;
        }

        $titre = trim($_POST['titre']);
        $auteur_id = (int) $_POST['auteur_id'];
        $categorie_id = (int) $_POST['categorie_id'];
        $annee_publication = (int) $_POST['annee_publication'];
        $isbn = trim($_POST['isbn']);
        $synopsis = trim($_POST['synopsis']);
        $disponible = (int) $_POST['disponible'];
        $like = (int) $_POST['like'];

        try {
            $bookModel = new BookModel();
            $bookModel->updateBook(
                $id,
                $titre,
                $auteur_id,
                $categorie_id,
                $annee_publication,
                $isbn,
                $disponible,
                $synopsis,
                $like
            );

            $_SESSION['success'] = "Livre modifié avec succès";
        } catch (\RuntimeException $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: /books');
        exit;
    }

    public function delete(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /books');
            exit;
        }

        try {
            $bookModel = new BookModel();
            $bookModel->deleteBook($id);

            $_SESSION['success'] = "Livre supprimé avec succès";
        } catch (\RuntimeException $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: /books');
        exit;
    }

    public function toggleLike(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        header('Content-Type: application/json');

        try {
            $bookModel = new BookModel();
            $newLike = $bookModel->toggleLike($id);

            if ($newLike === null) {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Livre introuvable'
                ]);
                return;
            }

            echo json_encode([
                'success' => true,
                'liked' => $newLike
            ]);
        } catch (\RuntimeException $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        exit;
    }
}
