<?php

namespace Tests\Feature\Http\Controllers\api;

use App\Http\Controllers\api\AuthController;
use App\Models\Patient;
use App\Repositories\PatientRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Mockery\MockInterface;
use Tests\TestCase;
use const http\Client\Curl\AUTH_ANY;

class AuthControllerTest extends TestCase
{
    public function testSigninSuccess()
    {
        $mock = $this->mock(AuthController::class, function (MockInterface $mock) {
            $mock->shouldReceive('signin')->once();
        });
        $mock->expects(self::never())->method('sendResponse')->willReturn(false);
        $mock->expects(self::never())->method('sendError')->willReturn(false);
    }

    public function testSigninUnauthorized()
    {
        $authController = new AuthController();

        $response = $authController->signin(new Request(['email' => 'unauthorized@gmail.com', 'password' => 'x']));
        $this->assertArrayHasKey('success', json_decode($response->getContent(), true));
        $this->assertEquals(false, json_decode($response->getContent(), true)['success']);
        $this->assertEquals('Unauthorised', json_decode($response->getContent(), true)['data']['error']);
    }

    public function deleteUser(): void
    {
        $userRepository = new UserRepository();
        $userRepository->deleteByEmail('test@gmail.com');
    }

    public function createUser()
    {
        $authController = new AuthController();
        return $authController->signup(new Request(['name' => 'test', 'email' => 'test@gmail.com', 'password' => 'test', 'confirm_password' => 'test']));
    }

}
