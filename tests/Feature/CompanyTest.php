<?php

namespace Tests\Feature;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_find_company_name_method_exists()
    {
        $response = $this->get('/api/company/find_company_name');
        $response->assertStatus(200);
    }

//    public function test_find_company_create_method_exists()
//    {
//        $response = $this->post('/api/company/', [
//            'name' => 'Comp',
//            'country' => 'ltu',
//        ]);
//
//        $response->assertStatus(201);
//    }

//    public function test_the_company_model(){
//        Company::factory()->create();
//
//        $this->assertDatabaseCount('companies', 18);
//    }
}
