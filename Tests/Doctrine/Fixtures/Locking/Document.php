<?php

namespace Rouffj\Bundle\HowToBundle\Tests\Doctrine\Fixtures\Locking;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity();
 */
class Document
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     */
    public $title;

    /**
     * @ORM\Column(type="text")
     */
    public $content;

    /**
     * @ORM\Version
     * @ORM\Column(type="integer")
     */
    public $version;

    public function __construct($id, $title)
    {
        $this->id = $id;
        $this->title = $title;
    }
}
