<?php

use Illuminate\Database\Seeder;

class CostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('costs')->insert(['designation' => 'A0001','description' => 'ATEC - Matosinhos','created_at'=>now()]);
    }
}
