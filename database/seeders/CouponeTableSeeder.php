<?php

namespace Database\Seeders;

use App\Models\Coupone;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CouponeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 10; $i++) { 
            Coupone::create([
                'coupone' => Str::random(8),
                'discount' => rand(2 , 50)
            ]);
        }
    }
}
