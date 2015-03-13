<?php

namespace Esgi\BlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertTrue($crawler->filter('html:contains("error")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("et")')->count() > 0);	
    }

    public function testGetPosts()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/articles');

        $this->assertTrue($crawler->filter('html:contains("beatae")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("voluptate")')->count() > 0);	
        $this->assertTrue($crawler->filter('html:contains("neque")')->count() > 0);	
        $this->assertTrue($crawler->filter('html:contains("soluta")')->count() > 0);	
    }
}
