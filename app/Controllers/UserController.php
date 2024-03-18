<?php

namespace App\Controllers;

use App\Models\User;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use ReflectionException;

class UserController extends ResourceController
{
    protected $modelName = 'App\Models\User';
    protected $format    = 'json';

    public function create(): ResponseInterface
    {
        $model = new User();
        $json = $this->request->getJSON();
        $existingUser = $model->withDeleted()->where('username', $json->username)->first();

        if ($existingUser) {
            return $this->response
                ->setJSON(['error' => 'Username is already in use.'])
                ->setStatusCode(409);
        }

        $userData = [
            'username' => $json->username,
            'password' => password_hash($json->password, PASSWORD_DEFAULT),
            'role' => $json->role,
        ];

        if ($this->model->insert($userData)) {
            return $this->respondCreated(['message' => 'User created successfully']);
        } else {
            return $this->failServerError('Could not create the user');
        }
    }

    public function login(): ResponseInterface
    {
        $json = $this->request->getJSON();
        $user = $this->model->where('username', $json->username)->first();

        if (!$user) {
            return $this->failNotFound('User not found');
        }

        if (password_verify($json->password, $user['password'])) {
            return $this->respond(['message' => 'Login successful']);
        } else {
            return $this->failUnauthorized('Password does not match');
        }
    }

    public function show($id = null): ResponseInterface
    {
        $model = new User();
        $user = $model->find($id);

        if (!$user) {
            return $this->failNotFound('User not found');
        }

        unset($user['password']);

        return $this->respond($user);
    }

    /**
     * @throws ReflectionException
     */
    public function update($id = null): ResponseInterface
    {
        $model = new User();
        $json = $this->request->getJSON();
        $existingUser = $model->find($id);

        if (!$existingUser) {
            return $this->failNotFound('User not found');
        }

        $dataToUpdate = [];

        if (isset($json->username) && $json->username !== $existingUser['username']) {
            $dataToUpdate['username'] = $json->username;
        }

        if (isset($json->password)) {
            $dataToUpdate['password'] = password_hash($json->password, PASSWORD_DEFAULT);
        }

        if (!empty($dataToUpdate)) {
            $model->update($id, $dataToUpdate);
            return $this->respondUpdated(['message' => 'User profile updated successfully.']);
        } else {
            return $this->fail('No data to update');
        }
    }


}
