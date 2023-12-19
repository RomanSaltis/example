<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\CompanyOffice;
use App\Models\CompanyUser;
use App\Models\JobTitle;
use App\Models\User;
use App\Notifications\UserCreatedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class DatabaseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_the_company_user_relationship()
    {
        Notification::fake();
        $userCount = User::count();
        $companyCount = Company::count();

        $user = User::factory()
            ->hasAttached(Company::factory(),
                function(){
                    return ['salary' => rand(1500, 15000),
                        'job_title_id' => JobTitle::inRandomOrder()->first()->id,
                        'holiday' => rand(5, 25),
                        'company_office_id' => CompanyOffice::inRandomOrder()->first()->id];
                })
            ->create();

        $this->assertDatabaseCount('companies', ++$companyCount);
        $this->assertDatabaseCount('users', ++$userCount);
        $this->assertDatabaseHas('company_user', [
            'user_id' => $user->id,
        ]);

        $companyUser=CompanyUser::where('user_id', $user->id)->first();
        $this->assertEquals($user->id, $companyUser->user->id);

        $this->assertInstanceOf(User::class, $companyUser->user);
        $this->assertInstanceOf(Company::class, $companyUser->company);

        Notification::assertSentTo($user, UserCreatedNotification::class);
    }

//    public function test_the_authentication()
//    {
//        $superuser = User::where('email', '=', 'rick@hgv.com')->first();
////        $this->actingAs($superuser);
//
//
//        $user = User::factory()->create([
//            'password' => 'qwertyui',
//        ]);
//
//        $this->post('/api/user/login', [
//           'email' => $user->email,
//           'password' => 'qwertyui',
//        ]);
//
//        $this->assertAuthenticated();
//    }

//    public function test_user_can_create_company(){
//        $user = User::factory()->create();
//
//        $this->actingAs($user);
//        $response = $this->post('/api/company/', [
//            'name' => 'Company1',
//            'country' => 'ltu',
//        ]);
//
//        $response->assertStatus(201);
//
//        $company = Company::where('name', $response['name'])->first();
//
//        $this->assertEquals('Company1', $company->name);
//        $this->assertEquals('ltu', $company->country);
//
//    }
}
