<?php

namespace App\models;

use App\Config\Database;
use PDO;
use PDOException;
use RuntimeException;

class AuthorModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAllAuthors(): ?array
    {
        try {
            $query = $this->db->prepare(
                'SELECT id, nom, prenom, biographie FROM auteurs'
            );
            $query->execute();
            $auteursData = $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new RuntimeException("Erreur lors de la récupération des auteurs");
        }

        return $auteursData;
    }

    public function getAuthorById(int $id): ?array
    {
        try {
            $query = $this->db->prepare(
                'SELECT id, nom, prenom, biographie 
             FROM auteurs 
             WHERE id = :id'
            );

            $query->execute([':id' => $id]);
            $author = $query->fetch(PDO::FETCH_ASSOC);

            return $author ?: null;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new RuntimeException("Erreur lors de la récupération de l'auteur");
        }
    }

    public function addAuthor(string $nom, string $prenom, string $biographie): bool
    {
        try {
            $query = $this->db->prepare(
                'INSERT INTO auteurs (nom, prenom, biographie)
                 VALUES (:nom, :prenom, :biographie)'
            );

            return $query->execute([
                ':nom'        => $nom,
                ':prenom'     => $prenom,
                ':biographie' => $biographie
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new RuntimeException("Erreur lors de l'ajout de l'auteur");
        }
    }

    public function updateAuthor(int $id, string $nom, string $prenom, string $biographie): bool
    {
        try {
            $query = $this->db->prepare(
                'UPDATE auteurs 
                 SET nom = :nom, prenom = :prenom, biographie = :biographie
                 WHERE id = :id'
            );

            return $query->execute([
                ':id'         => $id,
                ':nom'        => $nom,
                ':prenom'     => $prenom,
                ':biographie' => $biographie
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new RuntimeException("Erreur lors de la modification de l'auteur");
        }
    }

    public function deleteAuthor(int $id): bool
    {
        try {
            $query = $this->db->prepare(
                'DELETE FROM auteurs WHERE id = :id'
            );

            return $query->execute([
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new RuntimeException("Erreur lors de la suppression de l'auteur");
        }
    }
}
