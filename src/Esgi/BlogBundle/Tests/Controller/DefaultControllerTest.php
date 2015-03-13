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

        $crawler = $client->request('GET', '/articles/1');

        $this->assertTrue($crawler->filter('html:contains("error")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("et")')->count() > 0);	
        $this->assertTrue($crawler->filter('html:contains("itaque")')->count() > 0);	
        $this->assertTrue($crawler->filter('html:contains("molestiae")')->count() > 0);	
    }

    public function testgetPostByCategoryAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/article/category/vero');

        $this->assertTrue($crawler->filter('html:contains("quis")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("sed")')->count() > 0);   
        $this->assertTrue($crawler->filter('html:contains("itaque")')->count() > 0);    
        $this->assertTrue($crawler->filter('html:contains("molestiae")')->count() > 0); 
    }
}
