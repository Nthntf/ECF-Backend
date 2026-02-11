<?php

namespace App\Middlewares;

final class AuthMiddleware
{
    public static function check(): void
    {
        // Vérifie que l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
    }

    public static function guest(): void
    {
        // Empêche l'accès aux pages invité si déjà connecté
        if (isset($_SESSION['user'])) {
            header('Location: /home');
            exit;
        }
    }
}
