<?php 

use Illuminate\Database\Seeder;
use App\Models;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Country::class)->create([]);

    }
}
