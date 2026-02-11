<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class BaseController
{
    protected Environment $twig;

    public function __construct()
    {
        // Configure Twig avec le dossier des vues
        $loader = new FilesystemLoader(__DIR__ . '/../views');
        $this->twig = new Environment($loader, [
            'cache' => false,
        ]);

        // Rend le nom d'utilisateur disponible dans toutes les vues
        $this->twig->addGlobal(
            'username',
            isset($_SESSION['user']['username'])
                ? ucfirst($_SESSION['user']['username'])
                : null
        );

        // Rend le rôle disponible globalement dans Twig
        $this->twig->addGlobal('role', $_SESSION['user']['role']);
    }

    // Méthode utilitaire pour afficher une vue avec ses données
    protected function render($template, $data = []): void
    {
        echo $this->twig->render($template, $data);
    }
}
