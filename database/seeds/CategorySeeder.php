<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert(['name' => 'Informática','description' => 'Material Informático','created_at'=>now()]);
        DB::table('categories')->insert(['name' => 'Robótica','description' => 'Material Robótica','created_at'=>now()]);
    }
}
