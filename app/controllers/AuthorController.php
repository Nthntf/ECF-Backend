<?php

namespace App\Controllers;

use App\controllers\BaseController;
use App\models\AuthorModel;
use JasonGrimes\Paginator;
use Parsedown;

class AuthorController extends BaseController
{
    public function index()
    {
        $authorModel = new AuthorModel();

        $search = isset($_GET['search']) && trim($_GET['search']) !== ''
            ? trim($_GET['search'])
            : null;

        $currentPage = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $itemsPerPage = $_ENV['AUTHORS_PER_PAGE'];

        $totalItems = $authorModel->countAuthors($search);

        $urlPattern = $search
            ? '/authors?search=' . urlencode($search) . '&page=(:num)'
            : '/authors?page=(:num)';

        $paginator = new Paginator(
            $totalItems,
            $itemsPerPage,
            $currentPage,
            $urlPattern
        );

        if ($currentPage > $paginator->getNumPages() && $paginator->getNumPages() > 0) {
            header('Location: /authors');
            exit;
        }

        $offset = ($currentPage - 1) * $itemsPerPage;

        $authors = $authorModel->getAuthorsPaginated(
            $itemsPerPage,
            $offset,
            $search
        );

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
            'modal' => true,
            'paginator' => $paginator,
            'search' => $search
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

    public function show(int $id)
    {
        $authorModel = new AuthorModel();
        $author = $authorModel->getAuthorById($id);

        if (!$author) {
            http_response_code(404);
            echo "Auteur introuvable";
            exit;
        }

        $parsedown = new Parsedown();

        $auteur = [
            'id' => $author['id'],
            'prenom' => $author['prenom'],
            'nom' => $author['nom'],
            'biographie' => $parsedown->text($author['biographie'])
        ];

        $this->render('author_show.html.twig', [
            'title' => $auteur['prenom'] . ' ' . $auteur['nom'],
            'auteur' => $auteur
        ]);
    }
}
