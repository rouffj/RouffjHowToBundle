<?php

namespace Rouffj\Bundle\HowToBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;

abstract class WebTestCase extends BaseWebTestCase
{
    protected $client;

    public function setUp()
    {
        parent::setUp();

        $this->client = self::createClient();
    }
}
