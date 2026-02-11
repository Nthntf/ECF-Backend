<?php
// Démarre la session pour gérer l'authentification
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Charge les variables d'environnement (.env)
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

use AltoRouter;
use App\Middlewares\AuthMiddleware;

$router = new AltoRouter();

// Charge la définition des routes
require_once __DIR__ . '/../app/config/routes.php';

// Tente de faire correspondre l'URL à une route définie
$match = $router->match();

// Si aucune route ne correspond → erreur 404
if (!$match) {
    http_response_code(404);
    echo '404 - Page non trouvée';
    exit;
}

// Routes nécessitant une authentification
$protectedRoutes = ['home', 'books', 'authors', 'categories'];

// Routes accessibles uniquement aux visiteurs non connectés
$guestRoutes     = ['login'];

// Vérification des droits d'accès selon la route appelée
if (in_array($match['name'], $protectedRoutes, true)) {
    AuthMiddleware::check();
} elseif (in_array($match['name'], $guestRoutes, true)) {
    AuthMiddleware::guest();
}

// Récupère dynamiquement le contrôleur et la méthode depuis la route
[$controllerName, $method] = explode('@', $match['target']);
$controllerClass = "App\\Controllers\\{$controllerName}";

// Sécurité : vérifie l'existence du contrôleur
if (!class_exists($controllerClass)) {
    throw new RuntimeException("Controller {$controllerClass} introuvable");
}

$controller = new $controllerClass();

// Sécurité : vérifie l'existence de la méthode
if (!method_exists($controller, $method)) {
    throw new RuntimeException("Méthode {$method} introuvable dans {$controllerClass}");
}

// Appelle la méthode avec les paramètres de l'URL
call_user_func_array([$controller, $method], $match['params']);
