<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @noinspection PhpUndefinedVariableInspection */
$factory->define(App\Poi::class, function () {
    $faker = Faker\Factory::create('fr_FR');
    return [
        "id" => $faker->numberBetween(500000),
        "id_sitra1" => $faker->numerify("sitraRES###"),
        "type" => $faker->randomElement(["HEBERGEMENT_LOCATIF", "PATRIMOINE_CULTUREL", "RESTAURATION", "COMMERCE_ET_SERVICE", "EQUIPEMENT", "HOTELLERIE", "DEGUSTATION", "HOTELLERIE_PLEIN_AIR", "HEBERGEMENT_COLLECTIF", "PATRIMOINE_NATUREL"]),
        "type_detail" => $faker->realText(100),
        'name' => "{$faker->company} {$faker->companySuffix}",
        'address' => $faker->address,
        'zip_code' => $faker->randomNumber(6),
        'town' => $faker->city,
        'phone' => $faker->numerify("0#########"),
        'fax' => $faker->numerify("0#########"),
        'fax_phone' => $faker->numerify("0#########"),
        'email' => $faker->email,
        'website' => $faker->url,
        'facebook' => $faker->url,
        'rank' => $faker->randomDigit,
        'opening_times' => $faker->realText(500),
        'price' => $faker->realText(500),
        'pricemin' => $faker->randomFloat(2, 10, 100),
        'pricemax' => $faker->randomFloat(2, 100, 500),
        'author' => $faker->name,
        'gid' => $faker->randomNumber(4),
        'creation_date' => $faker->dateTime,
        'last_update' => $faker->dateTime,
        'last_update_fme' => $faker->dateTime,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
    ];
});
