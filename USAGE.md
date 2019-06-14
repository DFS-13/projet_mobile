# Notes à destination des développeurs

## Installation de l'Api

### Requirements

- php 7.2
  - xml, mbstring, openssl
  - composer
- Mysql

### WebServer

Le webserver doit pointer le dossier `./api/src/public`. Le mode de réécriture d'url doit être activé.

### Configuration du projet

L'api est codée sur [Lumen]([href](https://lumen.laravel.com/docs/5.8)). Il faut créer un fichier `./api/src/.env` sur la base de `.env.example` qui se trouve au même endroit.

Les dépendances sont téléchargées grace à *composer*. Exécuter `composer install` à la racine du projet de l'api.

Le projet est livré avec les migrations et un seeder qui permettront de récupérer automatiquement les données de la ville de Lyon et de les enregistrer pour une utilisation dans l'api. Exécuter `php artisan migrate:fresh --seed` depuis `src`.

### Exécuter les tests

L'api est livrée avec une batterie de tests d'intégration pour les endpoints principaux. Pour les exécuter, taper la commande `vendor/bin/phpunit` depuis la racine de l'api.

## Documentation de l'API

### GET /pois

Retourne la liste complète des entrées de la ville (~5400 objets)

result:

```json
[{
    "id": "number",
    "id_sitra1": "string",
    "type": "string",
    "type_detail": "string",
    "name": "string",
    "address": "string",
    "zip_code": "number",
    "town": "string",
    "phone": "string",
    "fax": "string",
    "fax_phone": "string",
    "email": "string",
    "website": "string",
    "facebook": "string",
    "rank": "string",
    "opening_times": "string",
    "price": "string",
    "pricemin": "number",
    "pricemax": "number",
    "author": "string",
    "gid": "number",
    "creation_date": "DateTime",
    "last_update": "DateTime",
    "last_update_fme": "DateTime",
    "latitude": "number",
    "longitude": "number"
}]
```

Status Codes:

- 200: OK

### GET /pois/{id}

Retourne l'entrée identifiée par l'`id` dans l'url

result:

```json
{
    "id": "number",
    "id_sitra1": "string",
    "type": "string",
    "type_detail": "string",
    "name": "string",
    "address": "string",
    "zip_code": "number",
    "town": "string",
    "phone": "string",
    "fax": "string",
    "fax_phone": "string",
    "email": "string",
    "website": "string",
    "facebook": "string",
    "rank": "string",
    "opening_times": "string",
    "price": "string",
    "pricemin": "number",
    "pricemax": "number",
    "author": "string",
    "gid": "number",
    "creation_date": "DateTime",
    "last_update": "DateTime",
    "last_update_fme": "DateTime",
    "latitude": "number",
    "longitude": "number"
}
```

Status Codes:

- 200: OK
- 404: Resource not found

### POST /pois

Crée une entrée

body:

```json
{
    "id": "number",
    "id_sitra1": "string",
    "type": "string",
    "type_detail": "string",
    "name": "string",
    "address": "string",
    "zip_code": "number",
    "town": "string",
    "phone": "string",
    "fax": "string",
    "fax_phone": "string",
    "email": "string",
    "website": "string",
    "facebook": "string",
    "rank": "string",
    "opening_times": "string",
    "price": "string",
    "pricemin": "number",
    "pricemax": "number",
    "author": "string",
    "gid": "number",
    "latitude": "number",
    "longitude": "number"
}
```

Validation Details:

```php
[
    'id' => 'required|integer|unique:poi',
    'zip_code' => 'integer|nullable',
    'email' => 'email|nullable',
    'pricemin' => 'numeric|nullable',
    'pricemax' => 'numeric|nullable',
    'phone' => 'regex:/^0[0-9](?: ?[0-9]{2}){4}$/|nullable',
    'fax' => 'regex:/^0[0-9](?: ?[0-9]{2}){4}$/|nullable',
    'fax_phone' => 'regex:/^0[0-9](?: ?[0-9]{2}){4}$/|nullable',
    'gid' => 'integer|nullable',
    'latitude' => 'required|numeric',
    'longitude' => 'required|numeric',
]
```

Result:

```json
{}
```

Status Codes:

- 201: Resource successfully created
- 400: Data validation failed

result :

```json
{
    "message": "The server can't validate the request data",
    "errors": {
        "id": "The id must be an integer.",
        "zip_code": "The zip code must be an integer.",
        "email": "The email must be a valid email address.",
        "pricemin": "The pricemin must be a number.",
        "pricemax": "The pricemax must be a number.",
        "phone": "The phone format is invalid.",
        "fax": "The fax format is invalid.",
        "fax_phone": "The fax phone format is invalid.",
        "gid": "The gid must be an integer.",
        "latitude": "The latitude must be a number.",
        "longitude": "The longitude must be a number."
    }
}
```

### PUT /pois/{id}

Modifie une entrée

body:

```json
{
    "type": "string",
    "type_detail": "string",
    "name": "string",
    "address": "string",
    "zip_code": "number",
    "town": "string",
    "phone": "string",
    "fax": "string",
    "fax_phone": "string",
    "email": "string",
    "website": "string",
    "facebook": "string",
    "rank": "string",
    "opening_times": "string",
    "price": "string",
    "pricemin": "number",
    "pricemax": "number",
    "latitude": "number",
    "longitude": "number"
}
```

Validation Details:

```php
[
    'zip_code' => 'integer|nullable',
    'email' => 'email|nullable',
    'pricemin' => 'numeric|nullable',
    'pricemax' => 'numeric|nullable',
    'phone' => 'regex:/^0[0-9](?: ?[0-9]{2}){4}$/|nullable',
    'fax' => 'regex:/^0[0-9](?: ?[0-9]{2}){4}$/|nullable',
    'fax_phone' => 'regex:/^0[0-9](?: ?[0-9]{2}){4}$/|nullable',
    'latitude' => 'required|numeric',
    'longitude' => 'required|numeric',
]
```

Result:

```json
{}
```

Status Codes:

- 201: Resource successfully created
- 400: Data validation failed

result :

```json
{
    "message": "The server can't validate the request data",
    "errors": {
        "zip_code": "The zip code must be an integer.",
        "email": "The email must be a valid email address.",
        "pricemin": "The pricemin must be a number.",
        "pricemax": "The pricemax must be a number.",
        "phone": "The phone format is invalid.",
        "fax": "The fax format is invalid.",
        "fax_phone": "The fax phone format is invalid.",
        "latitude": "The latitude must be a number.",
        "longitude": "The longitude must be a number."
    }
}
```

- 404: Resource not found

### DELETE /pois/{id}

Efface l'entrée

Status Codes:

- 204: Resource Successfully removed
- 404: Resource not found

## Installation de l'app mobile

L'app mobile ne contient aucune feature intéressante, nous ne l'avons pas publiée.

Pour lancer les dources, utiliser Android Studio et ouvrir le dossier app du repo.

## Avancées sur l'app

Consulter les issues du repository commun avec https://github.com/DFS-13/projet_mobile
