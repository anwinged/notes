<?php

declare(strict_types=1);

/* @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Note;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Note::class, static function (Faker $faker) {
    return [
        'source' => "# Header\n\nThis is a text.",
        'html' => '',
        'createdAt' => Carbon::now(),
        'updatedAt' => Carbon::now(),
        'archived' => false,
        'title' => 'Header',
        'short' => 'This is a text.',
    ];
});
