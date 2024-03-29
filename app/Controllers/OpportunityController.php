<?php

namespace App\Controllers;

use App\Models\Opportunity;
use App\Models\User;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use ReflectionException;

class OpportunityController extends ResourceController
{
    protected $modelName = 'App\Models\Opportunity';
    protected $format    = 'json';

    public function index(): ResponseInterface
    {
        $model = new Opportunity();
        $userModel = new User();

        $opportunities = $model->findAll();

        foreach ($opportunities as $key => $opportunity) {
            $recruiter = $userModel->find($opportunity['recruiter_id']);
            unset($recruiter['password']);
            $opportunities[$key]['recruiter'] = $recruiter;
        }

        return $this->respond($opportunities);
    }

    /**
     * @throws ReflectionException
     */
    public function create()
    {
        $model = new Opportunity();
        $json = $this->request->getJSON(true);

        if (!$model->insert($json)) {
            return $this->fail($model->errors());
        }

        return $this->respondCreated($json, 'Opportunity created');
    }

    public function delete($id = null)
    {
        $model = new Opportunity();

        $opportunity = $model->find($id);
        if (!$opportunity) {
            return $this->failNotFound('Opportunity not found');
        }

        if ($model->delete($id)) {
            return $this->respondDeleted(['message' => 'Opportunity deleted successfully', 'id' => $id], 'Opportunity deleted');
        } else {
            return $this->failServerError('Failed to delete the opportunity');
        }
    }

}
