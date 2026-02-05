<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Middlewares\AuthMiddleware;

class LoginController extends BaseController
{
    public function login(): void
    {
        // Si déjà connecté, redirige vers /home
        AuthMiddleware::guest();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            $userModel = new UserModel();
            $user = $userModel->findByUsername($username);

            // Regarde si bon password
            if (!$user || !password_verify($password, $user['password'])) {
                $_SESSION['error'] = 'Nom d\'utilisateur ou mot de passe incorrect';
                header('Location: /login');
                exit;
            }

            // Stocke l'utilisateur en session
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
            ];

            // Redirige vers /home
            header('Location: /home');
            exit;
        }

        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);

        $this->render('login.html.twig', [
            'error' => $error
        ]);
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: /login');
        exit;
    }
}
