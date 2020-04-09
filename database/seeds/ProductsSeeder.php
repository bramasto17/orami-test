<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        \DB::table('products')->truncate();
        \DB::table('products')->insert([
            [
                'id' => 1000,
                'name' => 'Product 1000',
            ],
            [
                'id' => 1001,
                'name' => 'Product 1001',
            ],
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
