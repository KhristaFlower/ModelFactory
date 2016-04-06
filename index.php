<?php

require 'vendor/autoload.php';

function factory($class = null) {

    $factory = App\Factory::getInstance();

    if ($class) {
        $factory->setClass($class);
    }

    return $factory;

}

factory()->define(Model\User::class, function(Faker\Generator $faker) {
    return [
        'username' => $faker->userName,
        'email' => $faker->email,
        'password' => $faker->password(),
        'dateOfBirth' => $faker->date('Y-m-d', strtotime('-18 years')),
        'countryCode' => $faker->countryCode
    ];
});

factory()->define(Model\Post::class, function(Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(6),
        'content' => $faker->paragraph(1),
        'posted_at' => $faker->dateTimeThisYear
    ];
});

print "One user:\n";
$user = factory(Model\User::class)->create();
var_export($user);

print "Three users:\n";
$users = factory(Model\User::class)->create(3);
var_export($users);

print "Users with posts:\n";
$users = factory(Model\User::class)
    ->create(2)
    ->each(function(Model\User $model) {
        $model->posts = factory(Model\Post::class)->create(2);
    });
var_export($users);
