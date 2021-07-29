# Blog MVC

## Altorouter
### Installation
- Dans un terminal, lancer la commande suivante : `composer require altorouter/altorouter`
    - Si besoin, il faut [installer composer](https://getcomposer.org/download/)
- Si besoin, il faut aussi [configurer le fichier htaccess](https://altorouter.com/usage/rewrite-requests.html) pour que toutes les requêtes redirige vers le fichier `index.php`
>> [Voir la doc](https://altorouter.com/usage/install.html)
### Configuration des routes (Mapping)
La création des routes se fait grâce à la méthode `map`
Cette méthode `map` prend 3 arguments obligatoires et un optionnel
- La méthode HTTP (GET ou POST par exemple)
- L'URL qui sera associée à la route (`/`)
- La target qui peut être n'importe quoi : une string, un tableau, une fonction anonyme (closure). Cette target sera retournée au moment d'appeler la méthode `match` d'Altorouter
- Le nom de la route. Cette valeur doit être unique et permettra la génération d'une url.
    - Ex : $router->generate('home') va générer `/`
>> [Voir la doc](https://altorouter.com/usage/mapping-routes.html)

1. Page d'accueil Accueil
```php
$router->map(
    'GET', 
    '/', 
    ['controller' => 'MainController', 'method' => 'home'], 
    'main-home'
);
```
- `$router->generate('home')` va générer `/`

1. Page d'article
```php
$router->map(
    'GET', 
    '/post/[i:postId]', 
    ['controller' => 'PostController', 'method' => 'show'], 
    'post-show'
);
```
- `$router->generate('post-show', ['postId' => 2])` va générer `/post/2`
