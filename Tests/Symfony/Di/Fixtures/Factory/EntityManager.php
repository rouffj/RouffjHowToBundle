<?php

namespace Rouffj\Bundle\HowToBundle\Tests\Symfony\Di\Fixtures\Factory;

class EntityManager
{
    public function getRepository($repositoryName)
    {
        return new UserRepository();
    }
}
