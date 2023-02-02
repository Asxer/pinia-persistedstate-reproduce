<?php 

use Illuminate\Database\Seeder;
use App\Models;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\City::class)->create([]);

    }
}
