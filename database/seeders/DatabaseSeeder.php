<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('users')->insert([
            'name' => 'Admin Sistem Informasi',
            'username' => 'admin',
            'role' => 'admin',
            'password' => bcrypt('admin'),
        ]);
        DB::table('users')->insert([
            'name' => 'Ketua RT',
            'username' => 'rt',
            'role' => 'rt',
            'password' => bcrypt('rt'),
        ]);
    }
}
