<?php

namespace Tests\Feature;

use Github\Client;
use GuzzleHttp\Psr7\Response;
use Github\HttpClient\Builder;
use Http\Mock\Client as MockClient;

trait MocksGithubAPI
{
    protected $mock;

    public function setUp(): void
    {
        parent::setUp();

        // $this->mock = new MockClient();

        // $client = new Client(new Builder($this->mock));
        
        // $this->app->instance(Client::class, $client);
    }
    /**
     * Adds a mock http response
     * @param mixed  $response
     * @param integer $status
     * @param array   $headers
     */
    protected function addMockHttpResponse($response, $status = 200, $headers = [])
    {
        $this->mock->addResponse(
            new Response($status, ['content-type' => 'Application/json'], $response)
        );

        return $this;
    }
}