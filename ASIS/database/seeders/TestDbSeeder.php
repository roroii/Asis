<?php

namespace Database\Seeders;

use App\Models\posgres_db\test_db;
use Illuminate\Database\Seeder;

class TestDbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         test_db::factory(10)->create();
    }
}
