<?php

namespace Tests\Feature;

use CodeIgniter\HTTP\Exceptions\RedirectException;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

class OpportunityControllerTest extends CustomTestBase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $migrateOnce = true;
    protected $migrate = true;
    protected $refresh = true;
    protected $seedOnce = true;
    protected $seed = 'OpportunitiesSeeder';

    protected $basePath = APPPATH . 'Database/';
    protected $namespace = 'App';

    public function testIndex()
    {
        $result = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->get('api/opportunities/');

        $this->assertTrue($result->isOK());

        $opportunities = json_decode($result->getJSON(), true);
        $this->assertIsArray($opportunities);
        $this->assertNotEmpty($opportunities);
    }

    /**
     * @throws RedirectException
     */
    public function testCreate()
    {
        $payload = json_encode([
            'title' => 'New Opportunity',
            'description' => 'Description of the opportunity.',
            'recruiter_id' => 1,
        ]);

        $result = $this->withBody($payload)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->token,
            ])->post('api/opportunity/create');

        $this->assertTrue($result->isOK());

        $createdOpportunity = json_decode($result->getJSON(), true);
        $this->assertEquals('New Opportunity', $createdOpportunity['title']);
    }

}
