<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(['role_id' => '1','cost_id' => '1','name' => 'admin','phone_number' => '919999999','email' => 'admin@admin.pt','password' => Hash::make('admin123'),'created_at'=>now()]);
    }
}
