<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Victor Peña';
        $user->email = 'victor@gmail.com';
        $user->password = bcrypt('admin');
        $user->email_verified_at = '2022-05-09';
        $user->remember_token = 'nNFhKn76Vic';
        $user->save();
    }
}
