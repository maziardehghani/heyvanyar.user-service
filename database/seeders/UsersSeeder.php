<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            'maziar' => [
                'mobile' => '09931591988',
                'password' => ''
            ],
           'ali' => [
               'mobile' => '9217332763',
               'password' => '12345678'
           ],

           'arman' => [
               'mobile' => '9338057197',
               'password' => '12345678'
           ],

           'mahdie' => [
               'mobile' => '9373803724',
               'password' => '12345678'
           ]

        ];

        foreach ($users as $user)
        {
            $user = User::create([
                User::MOBILE => $user['mobile'],
//                User::PASSWORD => Hash::make($user['password']),
            ]);
            $user->verify();
        }
    }
}
