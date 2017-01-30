<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class BookmarkControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    private function logIn()
    {
        /** @var Session $session */
        $session = $this->client->getContainer()->get('session');

        $firewall = 'main';

        $token = new UsernamePasswordToken('resurtm', '123123', $firewall, ['ROLE_USER']);
        $session->set('_security_' . $firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    public function testIndex()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/bookmarks');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Bookmarks', $crawler->filter('h1')->text());
    }
}
