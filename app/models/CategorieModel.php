<?php

namespace App\models;

use App\Config\Database;
use PDO;
use PDOException;
use RuntimeException;

class CategorieModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Récupère toutes les catégories triées par ID
    public function getAllCategories(): ?array
    {
        try {
            $query = $this->db->prepare('SELECT id, nom FROM categories ORDER BY id ASC');
            $query->execute();
            $categoriesData = $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new RuntimeException("Erreur lors de la récupération des catégories");
        }

        return $categoriesData;
    }

    // Ajoute une nouvelle catégorie
    public function addCategorie(string $nom): bool
    {
        try {
            $query = $this->db->prepare('INSERT INTO categories (nom) VALUES (:nom)');
            return $query->execute([':nom' => $nom]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new RuntimeException("Erreur lors de l'ajout de la catégorie");
        }
    }

    // Met à jour le nom d'une catégorie existante
    public function updateCategorie(int $id, string $nom): bool
    {
        try {
            $query = $this->db->prepare('UPDATE categories SET nom = :nom WHERE id = :id');
            return $query->execute([
                ':id'  => $id,
                ':nom' => $nom
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new RuntimeException("Erreur lors de la modification de la catégorie");
        }
    }

    // Supprime une catégorie par ID
    public function deleteCategorie(int $id): bool
    {
        try {
            $query = $this->db->prepare('DELETE FROM categories WHERE id = :id');
            return $query->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new RuntimeException("Erreur lors de la suppression de la catégorie");
        }
    }
}
