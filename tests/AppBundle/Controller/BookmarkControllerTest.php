<?php

namespace Tests\AppBundle\Controller;

use Tests\AppBundle\Test\WebTestCase;

class BookmarkControllerTest extends WebTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->logIn();
    }

    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/bookmarks');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Bookmarks', $crawler->filter('h1')->text());
    }
}
