<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

/**
 * @author Arotimmi Busayo <arotimi.busayo@gmail.com>
 *
 * Class RatingControllerTest
 * @package Test\Integration
 */
class RatingControllerTest extends TestCase
{
    private $client;

    public function setUp()
    {
        $this->client = new GuzzleHttp\Client(['base_uri' => 'http://localhost']);
    }

    public function tearDown()
    {
        $this->client = null;
    }

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     */
    public function testRateRecipeFailedValidation()
    {
        $data = ['rating' => 'Three'];

        $recipeId = 50;
        $response = $this->client->request('POST', '/recipes/'.$recipeId.'/rating', ['form_params' => $data, 'http_errors' => false]);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertFalse(json_decode($response->getBody(), true)['status']);
    }

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     */
    public function testRateRecipe()
    {
        $data = ['rating' => 3];

        $recipeId = 50;
        $response = $this->client->request('POST', '/recipes/'.$recipeId.'/rating', ['form_params' => $data, 'http_errors' => false]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(json_decode($response->getBody(), true)['status']);
    }
}
