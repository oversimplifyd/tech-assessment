<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

/**
 * @author Arotimmi Busayo <arotimi.busayo@gmail.com>
 *
 * Class RecipeControllerTest
 * @package Test\Integration
 */
class RecipeControllerTest extends TestCase
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
    public function testGetRecipes()
    {
        $response = $this->client->request('GET', '/recipes');
        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $this->assertTrue(json_decode($response->getBody(), true)['status']);
    }

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     */
    public function testCreateRecipesFailedValidation()
    {
        $data = [
            "name" => 'TestRecipe1 <>df<?',
            "prep_time" => 200,
            "difficulty" => "wrong",
            "vegetarian" => true
        ];

        $response = $this->client->request('POST', '/recipes', ['form_params' => $data, 'http_errors' => false]);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertFalse(json_decode($response->getBody(), true)['status']);
    }

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     */
    public function testCreateRecipe()
    {
        $data = [
            "name" => 'TestRecipe',
            "prep_time" => 200,
            "difficulty" => 1,
            "vegetarian" => 1
        ];

        $response = $this->client->request('POST', '/recipes', ['form_params' => $data, 'http_errors' => false]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(json_decode($response->getBody(), true)['status']);
    }

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     */
    public function testUpdateRecipe()
    {
        $data = [
            "name" => 'New Recipe',
            "prep_time" => 200,
            "difficulty" => 1,
            "vegetarian" => 1
        ];

        $recipe = $this->client->request('POST', '/recipes', ['form_params' => $data, 'http_errors' => false]);
        $recipeId = json_decode($recipe->getBody(), true)['data']['id'];

        $data = ['name' => 'Updated Recipe'];
        $response = $this->client->request('PUT', '/recipes/'.$recipeId, ['form_params' => $data, 'http_errors' => false]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Updated Recipe', json_decode($response->getBody(), true)['data']['name']);
    }

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     */
    public function testDeleteRecipe()
    {
        $data = [
            "name" => 'Another Recipe',
            "prep_time" => 210,
            "difficulty" => 1,
            "vegetarian" => 1
        ];

        $recipe = $this->client->request('POST', '/recipes', ['form_params' => $data, 'http_errors' => false]);
        $recipeId = json_decode($recipe->getBody(), true)['data']['id'];

        $response = $this->client->request('DELETE', '/recipes/'.$recipeId, ['http_errors' => false]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(json_decode($response->getBody(), true)['status']);
    }
}
