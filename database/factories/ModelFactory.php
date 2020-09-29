<?php

use Faker\Generator as Faker;

// ここにテーブルに投入するデータを定義する
$factory->define(App\Books::class, function (Faker $faker) {
    $now = \Carbon\Carbon::now();
    return [
        'name' => 'タイトル'.$faker->randomNumber(3),
        'bookdetail_id' => $faker->isbn13,
        'author_id' => $faker->randomNumber(4),
        'publisher_id' => $faker->randomNumber(5),
        'created_at' => $now,
        'updated_at' => $now,
    ];
});
