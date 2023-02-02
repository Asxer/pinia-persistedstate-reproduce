<?php

namespace App\Tests;

use App\Mails\ForgotPasswordMail;
use App\Tests\Support\AuthTestTrait;
use Illuminate\Support\Arr;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class AuthTest extends TestCase
{
    use AuthTestTrait;

    protected $admin;
    protected $users;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = User::find(1);
    }

    public function testLogin()
    {
        $response = $this->json('post', '/login', [
            'email' => 'admin@admin.com',
            'password' => '123'
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $this->assertArrayHasKey('token', $response->json());
    }

    public function testLoginWrongCredentials()
    {
        $response = $this->json('post', '/login', [
            'email' => 'wrong@email.com',
            'password' => 'wrong password'
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testRefreshToken()
    {
        $response = $this->actingAs($this->admin)->json('get', '/auth/refresh');

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertNotEmpty(
            $response->headers->get('authorization')
        );

        $auth = $response->headers->get('authorization');

        $explodedHeader = explode(' ', $auth);

        $this->assertNotEquals($this->jwt, last($explodedHeader));
    }
}
