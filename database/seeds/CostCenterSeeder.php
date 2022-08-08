<?php

use Illuminate\Database\Seeder;

class CostCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cost_centers')->insert(['designation' => 'A0001','description' => 'ATEC - Matosinhos','created_at'=>now()]);
        DB::table('cost_centers')->insert(['designation' => 'G0001','description' => 'ATEC - Matosinhos','created_at'=>now()]);
        DB::table('cost_centers')->insert(['designation' => 'F0001','description' => 'ATEC - Matosinhos','created_at'=>now()]);
    }
}
