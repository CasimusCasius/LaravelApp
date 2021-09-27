<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Faker\Factory;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function list(Request $request)
    {
        $users = [];

        $faker = Factory::create();
        $count = $faker->numberBetween(3, 15);
        for ($i = 0; $i < $count; $i++)
        {
            $users[] = [
                'id' => $faker->numberBetween(1, 1000),
                'name' => $faker->firstName
            ];
        }

        $session = $request->session();
        $session->put('prevAction', __METHOD__ . ':' . time());

        return view('user.list', [
            'users' => $users
        ]);
    }

    public function show(Request $request, int $userId)
    {
        $prevAction = $request->session()->get('prevAction');



        dump($prevAction);
        $faker = Factory::create();
        $user = [
            'id' => $userId,
            'name' => $faker->name,
            'firstName' => $faker->firstName,
            'lastName' => $faker->lastName,
            'city' => $faker->city,
            'age' => $faker->numberBetween(12, 25),
            'html' => '<script>alert("XSS")</script>'
        ];

        return view('user.show', [
            'user' => $user,
            'nick' => true
        ]);
    }
}
