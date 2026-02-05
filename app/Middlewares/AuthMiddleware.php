<?php

namespace App\Middlewares;

final class AuthMiddleware
{
    public static function check(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
    }

    public static function guest(): void
    {
        if (isset($_SESSION['user'])) {
            header('Location: /home');
            exit;
        }
    }
}
