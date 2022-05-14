<?php

namespace Tests;

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;

class JWTTest extends TestCase
{
    use DatabaseMigrations;

    public const PASSWORD = 'password';

    public function test_jwt_register_user()
    {
        /** @var User $user */
        $user = User::factory()->make();

        $response = $this->json('POST', '/auth/register', [
            'name'                  => $user->getName(),
            'email'                 => $user->getEmail(),
            'password'              => self::PASSWORD,
            'password_confirmation' => self::PASSWORD,
        ]);

        $response->assertResponseStatus(201);
        $response
            ->seeJsonStructure(['message', 'user'])
            ->seeJson([
                'message' => 'User has been successfully registered.',
                'user' => true,
            ]);
    }

    public function test_jwt_login_user()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->json('POST', '/auth/login', [
            'email'     => $user->email,
            'password'  => self::PASSWORD,
        ]);

        $response->assertResponseOk();
        $response->seeJsonStructure([
            'accessToken', 'tokenType', 'expiresIn'
        ]);
    }

    public function test_jwt_authenticated_user()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->json('POST', '/auth/login', [
            'email'     => $user->getEmail(),
            'password'  => self::PASSWORD,
        ]);

        $accessToken = json_decode($response->response->baseResponse->content())->accessToken;
        self::assertNotEmpty($accessToken, 'Empty access token');

        $response = $this->json(
            'GET',
            '/auth/me',
            [],
            ['Authorization' => 'Bearer '.$accessToken]
        );

        $response->assertResponseOk();
    }

    public function test_jwt_refresh_token()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->json('POST', '/auth/login', [
            'email'     => $user->getEmail(),
            'password'  => self::PASSWORD
        ]);

        $accessToken = json_decode($response->response->baseResponse->content())->accessToken;
        self::assertNotEmpty($accessToken, 'Empty access token');

        $response = $this->json(
            'GET',
            '/auth/refresh',
            [],
            ['Authorization' => 'Bearer '.$accessToken]
        );

        $newAccessToken = json_decode($response->response->baseResponse->content())->accessToken;

        self::assertNotEmpty($newAccessToken, 'Empty refreshed access token');
        self::assertNotEquals($newAccessToken, $accessToken, 'Token did not refresh');

        $response->assertResponseOk();
        $response->seeJsonStructure([
            'accessToken', 'tokenType', 'expiresIn'
        ]);
    }

    public function test_jwt_logout_user()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->json('POST', '/auth/login', [
            'email'     => $user->getEmail(),
            'password'  => self::PASSWORD
        ]);

        $accessToken = json_decode($response->response->baseResponse->content())->accessToken;
        self::assertNotEmpty($accessToken, 'Empty access token');

        $response = $this->json(
            'POST',
            '/auth/logout',
            [],
            ['Authorization' => 'Bearer '.$accessToken]
        );

        $response->assertResponseOk();
        $response->seeJson(['message' => 'Successfully logged out.']);
    }
}
