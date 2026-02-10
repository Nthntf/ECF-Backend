<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class BaseController
{
    protected Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../views');
        $this->twig = new Environment($loader, [
            'cache' => false,
        ]);
        $this->twig->addGlobal('username', isset($_SESSION['user']['username'])
            ? ucfirst($_SESSION['user']['username']) : null);
        $this->twig->addGlobal('role', $_SESSION['user']['role']);
    }

    protected function render($template, $data = []): void
    {
        echo $this->twig->render($template, $data);
    }
}
