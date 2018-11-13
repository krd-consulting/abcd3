<?php

use Faker\Generator as Faker;

use App\FileType as FileType;
use App\Team as Team;

$factory->define(App\File::class, function (Faker $faker) {
    $types = [
        0 => 'Participants',
        1 => 'Staff',
        2 => 'Volunteers'
    ];

    $typeId = rand(0, 2);
    $type = FileType::where('name', $types[$typeId])->first();

    $teamId = rand(1, 2);

    return [
        'file_type_id' => $type->id,
        'field_1_value' => $faker->firstName(),
        'field_2_value' => $faker->lastName(),
        'field_3_value' => $faker->companyEmail
    ];
});
