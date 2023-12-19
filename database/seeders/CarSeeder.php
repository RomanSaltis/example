<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Car;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;
use Psy\Util\Str;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            "Volvo" => ["400:500", "500:600"],
            "Renault" => ["3:500", "5:650"],
            "Mercedes" => ["S:1600", "GL:1200", "C:1300"],
        ];
        foreach ($brands as $brand => $details) {
            foreach ($details as $detail) {
                $model_price = explode(":", $detail);
                DB::table('cars')->insert([
                    'brand' => $brand,
                    'model' => $model_price[0],
                    'price' => $model_price[1],
               ] );
            }
        }

//
//        DB::table('cars')->insert([
//            'brand' => \Illuminate\Support\Str::random(6),
//            'model' => \Illuminate\Support\Str::random(4),
//            'price' => rand(100, 1000),
//        ]);

//        Car::factory()
//            ->count(10)
//            ->create();
    }
}
