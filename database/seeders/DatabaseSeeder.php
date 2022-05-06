<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'),
        ]);

        DB::table('roles')->insert([
            'name'=>'admin',
            'guard_name'=>'web'
        ]);

        DB::table('roles')->insert([
            'name'=>'city_manager',
            'guard_name'=>'web'
        ]);

        DB::table('roles')->insert([
            'name'=>'gym_manager',
            'guard_name'=>'web'
        ]);
        $user= User::where(['email'=>'admin@admin.com'])->first();
        $user->assignRole('admin');

    }
}
