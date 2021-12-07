
# Laradoc

  

[![Latest Version on Packagist][ico-version]][link-packagist]

[![Build Status][ico-travis]][Active]

Implémenter une documentation dynamique sur *Laravel* n'a jamais été aussi facile.


## Installation

#### 1) Téléchargement
Cloner le repository dans ./packages/victoranw
Le path complet une fois le repository cloné est: ./packages/victoranw/laradoc

#### 2) Composer

Ajouter dans composer.json
``` json
"repositories": {
	"victoranw/laradoc": {
		"type": "path",
		"url": "./packages/victoranw/laradoc"
	}
}
```

Dans le terminal

``` bash
$ composer require victoranw/laradoc
```

#### 3) Provider

Ajouter dans le fichier config/app.php

``` php
'providers'  => [
	\Victoranw\Laradoc\LaradocServiceProvider::class
]
```

#### 4) Installation des fichiers

Installer les fichiers de configurations et de migrations
``` bash
$ php artisan vendor:publish --provider="Victoranw\Laradoc\LaradocServiceProvider"
```

#### 5) Migration

Lancer la migration
``` bash
$ php artisan migrate
```

#### 6) Cache

Nettoyer le cache
``` bash
$ php artisan config:clear
$ php artisan route:clear
```

## Configuration

 Path: *./config/laradoc.php*
 
 
| Clé | Description |
|--|--|
| name | Nom du projet |
| logo | Url du logo du projet |
| color | Charte graphique: couleur principale |
| url_prefix | Base de l'url pour la documentation |
| auth.guard | Nom du guard à utiliser pour la session |
| auth.loginColumn | Column de la table sql à lire pour le username |
| auth.passwordColumn | Column de la table sql à lire pour le mot de passe |

## Utilisation

Rendez-vous sur http://localhost:8000/doc pour accéder à la connexion.
*** Attention: vérifier bien si l'utilisateur que vous voulez connecté à l'autorisation d'accès à la documentation ***

Une fois connecté, vous pouvez consulter la documentation ou passer sur l'espace administrateur

#### Espace administrateur

L'espace administrateur se divise en deux parties, une partie pour la gestion du contenu de la documentation et une autre pour la gestion des accès des utilisateurs.

##### Gestion du contenu de la documentation

Les premières branches de l'arbre vont être les catégories principales.
Ensuite, dans celles-ci, vous pouvez ajouter autant de sous catégories que vous le souhaitez. Dans chaque catégorie il est possible d'ajouter une ou plusieurs page, ce qui créera votre sous-menu lors de la lecture de la documentation.
Lors de la rédaction de la page, tout s'enregistre automatiquement (titre et contenu de la page).

##### Gestion des utilisateurs

La gestion des utilisateurs est simple, elle se résume à deux actions:
* Ajouter / Supprimer l'accès d'un utilisateur à la lecture de la documentation
* Ajouter / Supprimer l'accès d'un utilisateur à l'espace administrateur

## Testing

``` bash

$ ./vendor/bin/phpunit

```



## Security
Si un problème est rencontré, merci de contacter victor.anweiler@epitech.eu



## Credits
* [Victor Anweiler](https//victoranw.fr)



[ico-version]: https://img.shields.io/packagist/v/victoranw/laradoc.svg?style=flat-square

[ico-downloads]: https://img.shields.io/packagist/dt/victoranw/laradoc.svg?style=flat-square

[ico-travis]: https://img.shields.io/travis/victoranw/laradoc/master.svg?style=flat-square

[ico-styleci]: https://styleci.io/repos/12345678/shield

  

[link-packagist]: https://packagist.org/packages/victoranw/laradoc

[link-downloads]: https://packagist.org/packages/victoranw/laradoc

[link-travis]: https://travis-ci.org/victoranw/laradoc

[link-styleci]: https://styleci.io/repos/12345678

[link-author]: https://github.com/victoranw
