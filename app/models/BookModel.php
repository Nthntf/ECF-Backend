<?php

namespace App\models;

use App\Config\Database;
use PDO;
use PDOException;
use RuntimeException;

class BookModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAllBooks(): ?array
    {
        try {
            $query = $this->db->prepare(
                'SELECT 
                    l.id,
                    l.titre,
                    l.annee_publication,
                    l.isbn,
                    l.disponible,
                    l.synopsis,
                    l.`like` AS is_liked,

                    a.id AS auteur_id,
                    a.nom AS auteur_nom,
                    a.prenom AS auteur_prenom,

                    c.id AS categorie_id,
                    c.nom AS categorie_nom

                FROM livres l
                INNER JOIN auteurs a ON l.auteur_id = a.id
                INNER JOIN categories c ON l.categorie_id = c.id'
            );

            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new RuntimeException("Erreur lors de la récupération des livres");
        }
    }

    public function addBook(
        string $titre,
        int $auteur_id,
        int $categorie_id,
        int $annee_publication,
        string $isbn,
        bool $disponible,
        string $synopsis,
        bool $like
    ): bool {
        try {
            $query = $this->db->prepare(
                'INSERT INTO livres 
                (titre, auteur_id, categorie_id, annee_publication, isbn, disponible, synopsis, `like`)
                VALUES 
                (:titre, :auteur_id, :categorie_id, :annee_publication, :isbn, :disponible, :synopsis, :like)'
            );

            return $query->execute([
                ':titre' => $titre,
                ':auteur_id' => $auteur_id,
                ':categorie_id' => $categorie_id,
                ':annee_publication' => $annee_publication,
                ':isbn' => $isbn,
                ':disponible' => $disponible,
                ':synopsis' => $synopsis,
                ':like' => $like
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new RuntimeException("Erreur lors de l'ajout du livre");
        }
    }

    public function updateBook(
        int $id,
        string $titre,
        int $auteur_id,
        int $categorie_id,
        int $annee_publication,
        string $isbn,
        bool $disponible,
        string $synopsis,
        bool $like
    ): bool {
        try {
            $query = $this->db->prepare(
                'UPDATE livres SET
                    titre = :titre,
                    auteur_id = :auteur_id,
                    categorie_id = :categorie_id,
                    annee_publication = :annee_publication,
                    isbn = :isbn,
                    disponible = :disponible,
                    synopsis = :synopsis,
                    `like` = :like
                WHERE id = :id'
            );

            return $query->execute([
                ':id' => $id,
                ':titre' => $titre,
                ':auteur_id' => $auteur_id,
                ':categorie_id' => $categorie_id,
                ':annee_publication' => $annee_publication,
                ':isbn' => $isbn,
                ':disponible' => $disponible,
                ':synopsis' => $synopsis,
                ':like' => $like
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new RuntimeException("Erreur lors de la modification du livre");
        }
    }

    public function deleteBook(int $id): bool
    {
        try {
            $query = $this->db->prepare(
                'DELETE FROM livres WHERE id = :id'
            );

            return $query->execute([
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new RuntimeException("Erreur lors de la suppression du livre");
        }
    }

    public function toggleLike(int $id): ?bool
    {
        try {
            $query = $this->db->prepare(
                'SELECT `like` FROM livres WHERE id = :id'
            );
            $query->execute([':id' => $id]);
            $book = $query->fetch(PDO::FETCH_ASSOC);

            if (!$book) {
                return null;
            }

            $newLike = $book['like'] ? 0 : 1;

            $update = $this->db->prepare(
                'UPDATE livres SET `like` = :like WHERE id = :id'
            );

            $update->execute([
                ':like' => $newLike,
                ':id' => $id
            ]);

            return (bool) $newLike;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new RuntimeException("Erreur lors du changement de like");
        }
    }
}
