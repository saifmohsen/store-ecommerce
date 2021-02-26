<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [ // الشغلات اللي ال factory راح يضيفلي فيها بيانات من عنده
        'name' => $faker->word(), // طبعا name موجود في مودل ال Category او انه الباكيج نفسها بتفهم الامر انه في relationship
        // ييعني بققدر اضيف فيه عادي
        'slug' => $faker->slug(), // ال slug عبارة عن نوع من البيانات
        'is_active' => $faker->boolean(),
    ]; //طبعا بنفذه من خلال seeder اللي انا عملته واللي هو اسمه CategoryDatabaseSeeder
});
