<?php

namespace Tests\AppBundle\Controller;

use Tests\AppBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->logIn();
    }

    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/users');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains('All Users', $crawler->filter('h1')->text());
    }

    public function testNewUsers()
    {
        $crawler = $this->client->request('GET', '/users/new');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains('New Users', $crawler->filter('h1')->text());
    }
}
