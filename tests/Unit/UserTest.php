<?php

namespace Tests\Unit;

use App\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
	/** @test **/
    public function user_with_no_role_should_return_self_scope() 
    {
    	$user = factory(User::class)->make();

    	$this->assertEquals($user->scope, config('auth.scopes.self.name'));
    }
}
