<?php

use Illuminate\Database\Seeder;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        \DB::table('locations')->truncate();
        \DB::table('locations')->insert([
            [
                'id' => 1,
                'name' => 'Location 1',
            ],
            [
                'id' => 2,
                'name' => 'Location 2',
            ],
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
