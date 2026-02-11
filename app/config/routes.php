<?php

// Login
$router->map('GET|POST', '/login', 'LoginController@login', 'login');
$router->map('GET', '/logout', 'LoginController@logout', 'logout');

// Accueil
$router->map('GET', '/home', 'HomeController@index', 'home');
$router->map('GET', '/', 'HomeController@redirect', 'homePage');

// ==== PAGES ====
// Categories
$router->map('GET', '/categories', 'CategorieController@index', 'categories');
$router->map('POST', '/categories/add', 'CategorieController@add');
$router->map('POST', '/categories/[i:id]/update', 'CategorieController@update');
$router->map('POST', '/categories/[i:id]/delete', 'CategorieController@delete');

// Auteurs
$router->map('GET', '/authors', 'AuthorController@index', 'authors');
$router->map('POST', '/authors/add', 'AuthorController@add');
$router->map('POST', '/authors/[i:id]/update', 'AuthorController@update');
$router->map('POST', '/authors/[i:id]/delete', 'AuthorController@delete');

// Livres
$router->map('GET', '/books', 'BookController@index', 'books');
$router->map('POST', '/books/add', 'BookController@add');
$router->map('POST', '/books/[i:id]/update', 'BookController@update');
$router->map('POST', '/books/[i:id]/delete', 'BookController@delete');
$router->map('POST', '/books/[i:id]/like', 'BookController@toggleLike');
