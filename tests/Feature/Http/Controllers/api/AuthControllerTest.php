<?php

namespace Tests\Feature\Http\Controllers\api;

use App\Http\Controllers\api\AuthController;
use Illuminate\Http\Request;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{

    public function setUp(): void
    {
        $authController = new AuthController();

        $authController->signup(new Request([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'test',
            'confirm_password' => 'test'
        ]));

    }

    public function tearDown(): void
    {

    }

    public function testSignin()
    {
        $authController = new AuthController();

        $response = $authController->signin(new Request(['email' => 'test@gmail.com', 'password' => 'test']));
        var_dump(json_decode($response->getContent(), true));
        $this->assertArrayHasKey('success', json_decode($response->getContent(), true));
        $this->assertEquals(true, json_decode($response->getContent(), true)['success']);
        $this->assertEquals('test', json_decode($response->getContent(), true)['data']['name']);
        $this->assertEquals('User signed in', json_decode($response->getContent(), true)['message']);

    }

    public function testSigninUnauthorized()
    {
        $authController = new AuthController();

        $response = $authController->signin(new Request(['email' => 'unauthorized@gmail.com', 'password' => 'x']));
        var_dump(json_decode($response->getContent(), true));
        $this->assertArrayHasKey('success', json_decode($response->getContent(), true));
        $this->assertEquals(false, json_decode($response->getContent(), true)['success']);
        $this->assertEquals('Unauthorised', json_decode($response->getContent(), true)['data']['error']);
    }

}