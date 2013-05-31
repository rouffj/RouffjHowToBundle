<?php

namespace Rouffj\Bundle\HowToBundle\Tests\Symfony\Di;

use Rouffj\Bundle\HowToBundle\Tests\WebTestCase;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class DependencyInjectionTest extends WebTestCase
{
    private $container;
    private $contailerLoader;

    public function setUp()
    {
        parent::setUp();
        $this->container = new ContainerBuilder();
        $this->containerLoader = new XmlFileLoader($this->container, new FileLocator(array(__DIR__.'/Fixtures')));
    }

    /**
     * Possible use cases:
     * - When you want to transform Doctrine repositories as service to inject it some dependencies.
     */
    public function testHowToTransformFactoryResultingObjectAsService()
    {
        $this->containerLoader->load('Factory/services.xml');

        $this->assertInstanceOf('Rouffj\Bundle\HowToBundle\Tests\Symfony\Di\Fixtures\Factory\UserRepository', $this->container->get('repository.user'));
        $this->assertEquals('foo', $this->container->get('repository.user')->getPropertyA());
    }
}
