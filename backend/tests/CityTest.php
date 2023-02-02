<?php

namespace App\Tests;

use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class CityTest extends TestCase
{
    protected $user;

    public function setUp() : void
    {
        parent::setUp();

        $this->user = User::find(1);
    }

    public function testCreate()
    {
        $data = $this->getJsonFixture('create_city_request.json');

        $response = $this->actingAs($this->user)->json('post', '/cities', $data);

        $response->assertStatus(Response::HTTP_OK);

        $this->assertEqualsFixture('create_city_response.json', $response->json());

        $this->assertDatabaseHas('cities', $this->getJsonFixture('create_city_response.json'));
    }

    public function testCreateNoAuth()
    {
        $data = $this->getJsonFixture('create_city_request.json');

        $response = $this->json('post', '/cities', $data);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testUpdate()
    {
        $data = $this->getJsonFixture('update_city_request.json');

        $response = $this->actingAs($this->user)->json('put', '/cities/1', $data);

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseHas('cities', $data);
    }

    public function testUpdateNotExists()
    {
        $data = $this->getJsonFixture('update_city_request.json');

        $response = $this->actingAs($this->user)->json('put', '/cities/0', $data);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testUpdateNoAuth()
    {
        $data = $this->getJsonFixture('update_city_request.json');

        $response = $this->json('put', '/cities/1', $data);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testDelete()
    {
        $response = $this->actingAs($this->user)->json('delete', '/cities/1');

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('cities', [
            'id' => 1
        ]);
    }

    public function testDeleteNotExists()
    {
        $response = $this->actingAs($this->user)->json('delete', '/cities/0');

        $response->assertStatus(Response::HTTP_NOT_FOUND);

        $this->assertDatabaseMissing('cities', [
            'id' => 0
        ]);
    }

    public function testDeleteNoAuth()
    {
        $response = $this->json('delete', '/cities/1');

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testGet()
    {
        $response = $this->actingAs($this->user)->json('get', '/cities/1');

        $response->assertStatus(Response::HTTP_OK);

        $this->assertEqualsFixture('get_city.json', $response->json());
    }

    public function testGetNotExists()
    {
        $response = $this->actingAs($this->user)->json('get', '/cities/0');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function getSearchFilters()
    {
        return [
            [
                'filter' => ['all' => 1],
                'result' => 'search_all.json'
            ],
            [
                'filter' => [
                    'page' => 2,
                    'per_page' => 2
                ],
                'result' => 'search_by_page_per_page.json'
            ],
        ];
    }

    /**
     * @dataProvider getSearchFilters
     *
     * @param array $filter
     * @param string $fixture
     */
    public function testSearch($filter, $fixture)
    {
        $response = $this->actingAs($this->user)->json('get', '/cities', $filter);

        $response->assertStatus(Response::HTTP_OK);

        $this->assertEqualsFixture($fixture, $response->json());
    }

}
