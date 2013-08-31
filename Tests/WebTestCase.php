<?php

namespace Rouffj\Bundle\HowToBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Bundle\FrameworkBundle\Console\Application;

abstract class WebTestCase extends BaseWebTestCase
{
    protected $client;

    public function setUp()
    {
        parent::setUp();

        $this->client = self::createClient();

        $application = new Application(static::$kernel);
        $application->setAutoExit(false);
        $application->run(new ArrayInput(array(
            'doctrine:schema:drop',
            '--force' => true,
            '--full-database' => true,
            '--no-debug' => true,
            '--quiet'    => true,
        )));
        $application->run(new ArrayInput(array(
            'doctrine:schema:create',
            '--no-debug' => true,
            '--quiet'    => true,
        )));
        $application->run(new ArrayInput(array(
            'doctrine:fixtures:load',
            '--no-debug' => true,
            '--quiet'    => true,
        )));
    }
}
