<?php

namespace Rouffj\Bundle\HowToBundle\Tests\Doctrine\Fixtures\Internal;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity();
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $date;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $articleNumber;

    /**
     * @ORM\Column(type="string")
     */
    public $title;

    public function __construct($date, $articleNumber)
    {
        $this->date = $date;
        $this->articleNumber = $articleNumber;
    }
}
