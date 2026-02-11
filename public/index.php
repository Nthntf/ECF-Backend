<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

use AltoRouter;
use App\Middlewares\AuthMiddleware;


$router = new AltoRouter();

// Charge les routes
require_once __DIR__ . '/../app/config/routes.php';

$match = $router->match();
if (!$match) {
    http_response_code(404);
    echo '404 - Page non trouvée';
    exit;
}

// Route protégées par login
$protectedRoutes = ['home', 'books', 'authors', 'categories'];
$guestRoutes     = ['login'];

// Middleware
if (in_array($match['name'], $protectedRoutes, true)) {
    AuthMiddleware::check();
} elseif (in_array($match['name'], $guestRoutes, true)) {
    AuthMiddleware::guest();
}

// Sépare controllerName et sa methode pour l'appeler
[$controllerName, $method] = explode('@', $match['target']);
$controllerClass = "App\\Controllers\\{$controllerName}";

if (!class_exists($controllerClass)) {
    throw new RuntimeException("Controller {$controllerClass} introuvable");
}

$controller = new $controllerClass();

if (!method_exists($controller, $method)) {
    throw new RuntimeException("Méthode {$method} introuvable dans {$controllerClass}");
}

call_user_func_array([$controller, $method], $match['params']);
