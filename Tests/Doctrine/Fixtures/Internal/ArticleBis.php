<?php

namespace Rouffj\Bundle\HowToBundle\Tests\Doctrine\Fixtures\Internal;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity();
 */
class ArticleBis
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    public $title;
}
