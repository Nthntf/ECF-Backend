README Bibliothèque - ECF Back-End

Sommaire:

1. Présentation - Choix techniques
2. Technologies utilisées
3. Installation
4. Utilisation

### 1. Présentation - Choix techniques

Une application bibliothèque en PHP concept MVC.

Singleton -> app/config/Database.php
utilisé pour se connecter facilement à la base de données depuis n'importe quelle autre classe

.env utilisé en connexion PDO + config pagination

JQuery utilisé pour rapidité et faciliter dans la manipulation du DOM,
TailwindCSS utilisé pour faciliter et organiser l'utilisation du CSS

Twig utilisé pour les vues,

Altorouter pour une gestion simple des routes
Parsedown utilisé pour transformer le markdown en base de données en HTML elements,
Paginator utilisé pour la logique de pagination

### 2. Techno utilisées

Front:

- [JQuery](https://jquery.com/)
- Twig (voir ci-dessous)
- [TailwindCSS](https://tailwindcss.com/)

Back:

- Xampp, PHP, MariaDB + PhpMyAdmin
- [Altorouter](https://altorouter.com/)
- [Twig](https://twig.symfony.com/)
- [Parsedown](https://parsedown.org/)
- [Paginator by JasonGrimes](https://packagist.org/packages/jasongrimes/paginator)

### 3. INSTALLATION

.zip :
Base de donnée + .env dans le .zip

sinon :

- créer le .env à la racine du projet
- copier coller la config ci-dessous dans .env ->

```ini
DB_CONNECTION=mysql
DB_PORT=3306
DB_HOST=127.0.0.1
DB_DATABASE=bibliotheque
DB_USERNAME=root
DB_PASSWORD=
DB_CHARSET=utf8mb4

BOOKS_PER_PAGE=6
AUTHORS_PER_PAGE=6
```

```bash
composer install
```

```bash
php -S localhost:8000 -t public
```

### 4. UTILISATIONS

Comptes présents en base de données :

Id: admin
Mdp: admin123

Id: user
Mdp: user123

Pages disponibles:

- /login
  Connexion requise :
- /home
- /books
- /authors
- /categories

### 5. DIVERS

cmd utiles :

```bash
php -S localhost:8000 -t public
npx @tailwindcss/cli -i ./public/assets/css/input.css -o ./public/assets/css/output.css --watch
```
