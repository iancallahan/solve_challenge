<?php

namespace Tests\Feature;

use App\User;
use App\Role;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class UserTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    function test_logging_in_with_valid_credentials()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create([
            'email' => 'robocop@example.com',
            'password' => bcrypt('secret'),
        ]);
        $response = $this->post('/login', [
            'email' => 'robocop@example.com',
            'password' => 'secret',
        ]);
        $response->assertRedirect('/home');
        $this->assertTrue(Auth::check());
        $this->assertTrue(Auth::user()->is($user));
    }

    function test_logging_in_with_invalid_credentials()
    {
        $user = factory(User::class)->create([
            'email' => 'robocop@example.com',
            'password' => bcrypt('secret'),
        ]);
        $response = $this->post('/login', [
            'email' => 'robocop@example.com',
            'password' => 'opensecret',
        ]);
        $response->assertRedirect('/');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertFalse(Auth::check());
    }


    function test_logging_out_the_current_user()
    {
        Auth::login(factory(User::class)->create());
        $response = $this->post('/logout');
        $response->assertRedirect('/');
        $this->assertFalse(Auth::check());
    }

    function test_profile_requires_auth()
    {
        $response = $this->get('/profile');
        $response->assertRedirect('/login');
        $this->assertFalse(Auth::check());
    }

    function test_users_requires_auth()
    {
        $response = $this->get('/users');
        $response->assertRedirect('/login');
        $this->assertFalse(Auth::check());
    }

    function test_non_admin_no_access_to_users_index()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create([
            'email' => 'robocop@example.com',
            'password' => bcrypt('secret'),
        ]);
        $response = $this->actingAs($user)->get("/users");
        $response->assertRedirect('/home');
        $this->assertTrue(Auth::check());
        $this->assertTrue(Auth::user()->is($user));
    }

    function test_user_edit_profile()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create([
            'email' => 'robocop@example.com',
            'password' => bcrypt('secret'),
        ]);
        $response = $this->actingAs($user)->get("/profile");
        $response->assertSee('robocop@example.com');
        $response->assertViewIs('profile.form');
        $this->assertTrue(Auth::user()->is($user));
    }

}
