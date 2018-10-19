<?php

use Faker\Generator as Faker;

use App\FileType as FileType;

$factory->define(App\File::class, function (Faker $faker) {
    $types = [
        0 => 'Participants',
        1 => 'Staff',
        2 => 'Volunteers'
    ];

    $index = rand(0, 2);

    $type = FileType::where('name', $types[$index])->first();

    return [
        'file_type_id' => $type->id,
        'field_1_value' => $faker->firstName(),
        'field_2_value' => $faker->lastName(),
        'field_3_value' => $faker->date()
    ];
});
