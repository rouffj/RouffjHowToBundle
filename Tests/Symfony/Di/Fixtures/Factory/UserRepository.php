<?php

namespace Rouffj\Bundle\HowToBundle\Tests\Symfony\Di\Fixtures\Factory;

class UserRepository
{
    private $propertyA;

    public function setPropertyA($value)
    {
        $this->propertyA = $value;
    }

    public function getPropertyA()
    {
        return $this->propertyA;
    }
}
