<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Billing;
use Faker\Generator as Faker;

$factory->define(Billing::class, function (Faker $faker) {
    return [
        'username' =>$faker->userName,
           'mobile_number'=> $faker->phoneNumber,
            'amount_to_bill' =>$faker->numberBetween(1000,5000)
    ];
});
