<?php

// Login
$router->map('GET|POST', '/login', 'LoginController@login', 'login');
$router->map('GET', '/logout', 'LoginController@logout', 'logout');

// Accueil
$router->map('GET', '/home', 'HomeController@index', 'home');
$router->map('GET', '/', 'HomeController@redirect', 'homePage');

// Pages
$router->map('GET', '/books', 'BookController@index', 'books');
$router->map('GET', '/authors', 'AuthorController@index', 'authors');
$router->map('GET', '/categories', 'CategorieController@index', 'categories');
