<?php

use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('warehouses')->insert(['entity_id' => 1,'name' => 'ArmazemA','description' => '2º Andar','address' => 'Rua dos Alegres','phone_number' => '226587524','created_at'=>now()]);
    }
}
