<?php

use Illuminate\Database\Seeder;

class StocksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        \DB::table('stocks')->truncate();
        \DB::table('stocks')->insert([
            [
                'productId' => 1000,
                'locationId' => 1,
                'stock' => 21,
            ],
            [
                'productId' => 1000,
                'locationId' => 2,
                'stock' => 8,
            ],
            [
                'productId' => 1001,
                'locationId' => 1,
                'stock' => 4,
            ],
            [
                'productId' => 1001,
                'locationId' => 2,
                'stock' => 10,
            ],
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
