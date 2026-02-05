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

            if (!$user || !password_verify($password, $user['password'])) {
                $this->render('login.html.twig', [
                    'error' => 'Nom d\'utilisateur ou mot de passe incorrect',
                    'username' => $username
                ]);
                return;
            }

            // Stocke l'utilisateur en session
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
            ];

            // Redirige vers /home
            header('Location: /home');
            exit;
        }

        $this->render('login.html.twig');
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: /login');
        exit;
    }
}
