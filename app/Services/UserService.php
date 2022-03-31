<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService extends BasicService
{
    public function create($userData): array
    {
        DB::insert(
            "INSERT INTO users (name, surname, age, interests, city, email, password) VALUES (?,?,?,?,?,?,?)",
            [
                $userData['name'],
                $userData['surname'],
                $userData['age'],
                $userData['interests'],
                $userData['city'],
                $userData['email'],
                Hash::make($userData['password'])
            ]

        );

        return [
            'email' => $userData['email'],
            'password' => $userData['password']
        ];
    }

    public function getUserDataWithFriends(int $userId): array
    {
        $userData = $this->getFirst(
            DB::select(
                'SELECT id, name, surname, age, interests, city FROM users WHERE id = ?',
                [$userId]
            )
        );
        $userData->friendIds = $this->getColumn('second_user_id',
            DB::select(
                'SELECT first_user_id, second_user_id FROM friends WHERE first_user_id = ?',
                [$userId]
            ));

        return $userData;

    }

    public function getUserData(int $userId)
    {
        return $this->getFirst(DB::select('SELECT id, name, surname, age, interests, city FROM users WHERE id = ? limit 1', [$userId]));
    }

    public function getAllUsers()
    {
        return DB::select('SELECT id, name, surname, age, interests, city FROM users');
    }
}
