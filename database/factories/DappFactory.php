<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Dapp::class, function (Faker $faker) {
    return [
        'app_name' => 'test_app',
        'secret_key' => md5('test_key'),
        'status' => 0,
    ];
});
