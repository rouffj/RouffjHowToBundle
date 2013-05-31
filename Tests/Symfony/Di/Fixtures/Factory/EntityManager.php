<?php

namespace Rouffj\Bundle\HowToBundle\Tests\Symfony\Di\Fixtures\Factory;

class EntityManager
{
    private $repositories;

    public function __construct()
    {
        $this->repositories = array(
            'MyBundle:User' => new UserRepository()
        );
    }

    public function getRepository($repositoryName)
    {
        return $this->repositories[$repositoryName];
    }
}
