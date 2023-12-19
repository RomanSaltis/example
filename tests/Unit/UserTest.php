<?php

namespace Tests\Unit;

use App\Exceptions\EmailException;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_login_form(): void
    {
        $response = $this->post('/api/user/login');
        $response->assertStatus(200);
    }

    public function test_it_login_user()
    {
        $response = $this->post('/api/user/login', [
            'email' => 'rick@hgv.com',
            'password' => 'qwertyui'
        ]);
        $this->assertAuthenticated();
    }
//
    public function test_user_can_not_authenticate_with_invalid_password()
    {
        $response = $this->post('/api/user/login', [
            'email' => 'lrick@hgv.com',
            'password' => 'qwertyui'
        ]);
        $this->assertGuest();
    }

    public function test_user_duplication()
    {
        $user1 = User::make([
            'name' => 'Peter Moe',
            'email' => 'peter@ggg.com',
            'password' => 'qwertyui',
            'gender' => 'male'
        ]);

        $user2 = User::make([
            'name' => 'Loe Moe',
            'email' => 'loe@ggg.com',
            'password' => 'qwertyui',
            'gender' => 'male'
        ]);

        $this->assertTrue($user1->name != $user2->name);
    }
//
//    public function test_delete_user(){
//        $user = User::findOrFail(180);
//        if ($user){
//            $user->delete();
//        }
//
//        $this->assertTrue(true);
//    }
//


//    public function test_user_store()
//    {
//        $response = $this->post('api/user/', [
//            'name' => 'ardwdAmaDanika Pfannerstill',
//            'email' => 'pardwadmarudolph.okeefe@example.net',
//            'password' => 'qwertyui',
//            'gender' => 'male',
//        ]);
//
////        $response -> assertCreated();
//
//        $response ->assertStatus(201);
//    }

//    public function test_store_throws_exception()
//    {
//        $this->withoutExceptionHandling();
//        $this->expectException(EmailException::class);
//
//        $response = $this->post('api/user/', [
//            'name' => 'apardwdAmaDanika Pfannerstill',
//            'email' => 'appardwadmarudolph.okeefe@example.net',
//            'password' => 'qwertyui',
//            'gender' => 'male',
//        ]);
//    }

    public function test_database()
    {
        $this->assertDatabaseHas('users', [
            'name' => 'rick'
        ]);
    }
//
////    public function test_if_seeders_work(){
////        $this->seed();
////    }
//
    public function test_success_status(){
        $response = $this->get('api/user/test');
        $response->assertSuccessful();
    }

    public function test_str_ends_with_true()
    {
        $result=Str::endsWith('It is Monday', 'Monday');
        $this->assertTrue($result);
    }

    public function test_str_ends_with_false()
    {
        $result=Str::endsWith('It is Monday', 'Saturday');
        $this->assertFalse($result);
    }

    /**
    function adminUser(){
        static $user = null;
        if (is_null($user)){
        $user = \App\Models\User::find(config('app.admin_user_id'));
        }
        return $user;
    }
     */

    function adminUser(){
        static $user = null;
        if (is_null($user)){
            $user = \App\Models\User::find(config('app.admin_user_id'));
        }
        return $user;
    }

    /**
     * testing if getting User model instance (cached)
     * Always should return the admin user
     */
    public function test_is_admin_user_true(){
        $user = $this->adminUser();

        $this->assertInstanceOf(User::class, $user, 'Instance of the User model');
        $this->assertDatabaseHas('admin_users', [
            'user_id' => $user->id,
            'is_admin' => true,
        ]);
        $this->assertTrue($user->adminUser->is_admin, 'User is admin'); /* same as 'is_admin' => true, just don't know what is better*/
    }


//    public function test_is_admin_user_true(){
//        $user = User::factory()->create();
//        adminUser($user);
//        $this->assertTrue($user->isAdmin);

//        $result = AdminUser::where('user_id', $user->id))->first();
//        $this->assertTrue($result);
//    }
//
    public function test_is_admin_user_false(){
        $user = User::factory()->create();
        $this->assertFalse($user->isSuper);

//        $result = AdminUser::where('user_id', $user->id))->first();
//        $this->assertFalse($result);

    }

    function array_snake(array $props): array{
        return array_combine(array_map(fn($k) => Str::snake($k), array_keys($props)), array_values($props));
    }

    public function test_array_snake_works()
    {
        $props = ['firstNumber'=>'oneNumber', 'secondNumber'=>'twoNumber', 'thirdNumber'];
        $tested_props = $this->array_snake($props);
        $this->assertTrue(count($props) === count($tested_props), 'Same count' );

        $props_values = array_values($props);
        $tested_props_values = array_values($tested_props);
        $this->assertEmpty(array_diff($props_values, $tested_props_values), 'Values are equal ');

        $props_keys = array_keys($props);
        $tested_props_keys = array_keys($tested_props);

        for ($i=0; $i < count($tested_props); $i++)
        {
            $this->assertEquals(Str::snake($props_keys[$i]), $tested_props_keys[$i], 'Keys are snaked and equal');
        }
    }

    /**
     * php array_map for associative arrays
     * @param callable $f
     * @param array $a
     * @return array
     */

    function array_map_assoc(callable $f, array $a):array
    {
        return array_merge(...array_map($f, array_keys($a), $a));
    }

    /**
     * testing amount of arrays elements
     * testing values
     * testing keys
     * testing array keys with exclamation marks
     */

    public function test_array_map_assoc(){
        $a = ['Mercedes Benz S550'=> 'black car', 'BMW 750' => 'nice design', 2022, 'Like it' ];
        $ex_marks = "!!!!";
        $f = fn($r, $v) => [$r. $ex_marks => $v];
        $mapped_array = $this->array_map_assoc($f, $a);

        $this->assertCount(count($a), $mapped_array, 'Count elements in arrays in and out' );

        $this->assertEquals(array_values($a), array_values($mapped_array), 'Compare arrays values' );

        $a_keys = array_keys($a);
        foreach ($a_keys as $value){
            $a_keys_str[] = strval($value);
        }

        $mapped_array_keys = array_keys($mapped_array);
        foreach ($mapped_array_keys as $value){
            $mapped_array_keys_str[] = substr($value, 0, - strlen($ex_marks));
        }
        $this->assertEmpty(array_diff($mapped_array_keys_str, $a_keys_str), 'arrays keys are same');

        foreach ($a_keys_str as $value){
            $a_keys_with_ex[] = $value. $ex_marks;
        }
        $this->assertEmpty(array_diff($a_keys_with_ex, $mapped_array_keys), 'arrays with exclamation marks are equal');
    }
}
