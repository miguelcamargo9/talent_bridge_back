<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;

class AuthController extends ResourceController
{
    protected $modelName = 'App\Models\User';
    protected $format    = 'json';

    public function login(): ResponseInterface
    {
        $json = $this->request->getJSON();
        $user = $this->model->where('username', $json->username)->first();

        if (!$user) {
            return $this->failNotFound('User not found');
        }

        if (password_verify($json->password, $user['password'])) {
            $key = env('jwt.secret');
            $time = time();
            $payload = [
                'iss' => 'talent_bridge_back',
                'aud' => 'talent_bridge_front',
                'iat' => $time,
                'exp' => $time + 3600,
                'sub' => $user['id'],
            ];

            $jwt = JWT::encode($payload, $key, 'HS256');

            return $this->respond([
                'message' => 'Login successful',
                'token' => $jwt,
            ]);
        } else {
            return $this->failUnauthorized('Password does not match');
        }
    }
}

