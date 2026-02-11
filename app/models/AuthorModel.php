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

            // Retourne null si aucun résultat
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

    public function countAuthors(?string $search = null): int
    {
        try {
            $sql = 'SELECT COUNT(*) FROM auteurs';

            // Ajoute un filtre si recherche présente
            if ($search !== null && $search !== '') {
                $sql .= ' WHERE (
                        nom LIKE :search1
                        OR prenom LIKE :search2
                      )';
            }

            $query = $this->db->prepare($sql);

            if ($search !== null && $search !== '') {
                $value = '%' . $search . '%';
                $query->bindValue(':search1', $value, PDO::PARAM_STR);
                $query->bindValue(':search2', $value, PDO::PARAM_STR);
            }

            $query->execute();
            return (int) $query->fetchColumn();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getAuthorsPaginated(int $limit, int $offset, ?string $search = null): array
    {
        try {
            $sql = 'SELECT id, nom, prenom, biographie
                    FROM auteurs';

            // Filtre de recherche optionnel
            if ($search !== null && $search !== '') {
                $sql .= ' WHERE (
                        nom LIKE :search1
                        OR prenom LIKE :search2
                      )';
            }

            // Tri alphabétique + pagination
            $sql .= ' ORDER BY nom ASC
                      LIMIT :limit OFFSET :offset';

            $query = $this->db->prepare($sql);

            if ($search !== null && $search !== '') {
                $value = '%' . $search . '%';
                $query->bindValue(':search1', $value, PDO::PARAM_STR);
                $query->bindValue(':search2', $value, PDO::PARAM_STR);
            }

            $query->bindValue(':limit', $limit, PDO::PARAM_INT);
            $query->bindValue(':offset', $offset, PDO::PARAM_INT);

            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
