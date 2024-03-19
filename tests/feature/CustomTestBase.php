<?php

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use Firebase\JWT\JWT;

class CustomTestBase extends CIUnitTestCase
{
    protected string $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->token = $this->createTokenJWTTest();
    }

    protected function createTokenJWTTest(): string
    {
        $key = env('jwt.secret');
        $time = time();
        $payload = [
            'iss' => 'test_issuer',
            'aud' => 'test_audience',
            'iat' => $time,
            'exp' => $time + 3600,
        ];

        return JWT::encode($payload, $key, 'HS256');
    }
}
