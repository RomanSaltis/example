<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyOffice;
use App\Models\JobTitle;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(1)
            ->hasAttached(Company::factory(),
                function(){
                return [
                    'salary' => rand(1500, 15000),
                    'job_title_id' => JobTitle::inRandomOrder()->first()->id,
                    'holiday' => rand(5, 25),
                    'company_office_id' => CompanyOffice::inRandomOrder()->first()->id
                ];
                }
            )
            ->create();
    }
}
