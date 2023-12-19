<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserNameTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_str_ends_with()
    {
        $result=Str::endsWith('It is Monday', 'Monday');
        $this->assertTrue($result, true);
    }

    public function test_str_ends_user_name_true()
    {
        $rick = User::where('email', 'rick@hgv.com')->first();
        $result=Str::endsWith($rick->name, 'rick');
        $this->assertTrue($result);
    }

    public function test_str_ends_user_name_false()
    {
        $rick = User::where('email', 'rick@hgv.com')->first();
        $result=Str::endsWith($rick->name, 'rickas');
        $this->assertFalse($result);
    }

    public function test_is_Super_true()
    {
        $user = User::find(1);
        $this->assertTrue($user->isSuper);
    }

    public function test_is_Super_false()
    {
        $user = User::find(5);
        $this->assertFalse($user->isSuper);
    }



}
