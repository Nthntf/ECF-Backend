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

    public function getAllCategories(): ?array
    {
        try {
            $query = $this->db->prepare(
                'SELECT id, nom FROM categories'
            );
            $query->execute();
            $categoriesData = $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new RuntimeException("Erreur lors de la récupération des catégories");
        }

        return $categoriesData;
    }
}
