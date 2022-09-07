<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(['name' => 'ADMIN','created_at'=>now()]);
        DB::table('roles')->insert(['name' => 'GESTOR','created_at'=>now()]);
        DB::table('roles')->insert(['name' => 'FORMADOR','created_at'=>now()]);
        DB::table('roles')->insert(['name' => 'FORMANDO','created_at'=>now()]);
    }
}
