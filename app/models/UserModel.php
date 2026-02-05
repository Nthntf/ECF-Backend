<?php

namespace App\models;

use App\Config\Database;
use PDO;
use PDOException;
use RuntimeException;

class UserModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function findByUsername(string $username): ?array
    {
        try {
            $query = $this->db->prepare(
                'SELECT id, username, password FROM users WHERE username = :username'
            );
            $query->execute(['username' => $username]);
            $user = $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new RuntimeException("Erreur lors de la récupération de l'utilisateur");
        }

        return $user ?: null;
    }
}
