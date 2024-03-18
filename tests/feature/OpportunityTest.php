<?php

use App\Controllers\OpportunityController;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\TestResponse;

class OpportunityTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $migrateOnce = false;
    protected $migrate = true;

    protected $seedOnce = false;
    protected $seed = 'OpportunitiesSeeder';

    protected $basePath = APPPATH . 'Database/';
    protected $namespace = 'App';

    public function testIndex()
    {
        $result = $this->controller(OpportunityController::class)
            ->execute('index');

        $this->assertTrue($result->isOK());

        $opportunities = json_decode($result->getJSON(), true);
        $this->assertIsArray($opportunities);
        $this->assertNotEmpty($opportunities);
    }

    public function testCreate()
    {
        $payload = [
            'title' => 'New Opportunity',
            'description' => 'Description of the opportunity.',
            'recruiter_id' => 1,
        ];

        $result = $this->controller(OpportunityController::class)
            ->execute('create', $payload);

        $this->assertTrue($result->isCreated());


        $createdOpportunity = $result->getJSON(true);
        $this->assertEquals($payload['title'], $createdOpportunity['data']['title']);
    }

}
