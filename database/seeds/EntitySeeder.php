<?php

use Illuminate\Database\Seeder;

class EntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('entities')->insert(['name' => 'ATEC','address' => 'Rua Pinheiro Bravo 276','phone_number'=>'226587452','created_at'=>now()]);
        DB::table('entities')->insert(['name' => 'Siemens','address' => 'Rua de Cima 172','phone_number'=>'22568974','created_at'=>now()]);
    }
}
