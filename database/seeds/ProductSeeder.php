<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert(['category_id' => '1','warehouse_id' => '1','name' => 'Projetor','description' => 'Epson XP200','serial_number' => 'XP12345TZ','created_at'=>now()]);
    }
}
