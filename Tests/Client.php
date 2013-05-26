<?php

namespace Rouffj\Bundle\HowToBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Client as BaseClient;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Client
 *
 * @author Joseph Rouff <rouffj@gmail.com>
 */
class Client extends BaseClient
{
    public function openLink($linkText, Crawler $crawler, array $server = array())
    {
        try {
            $link = $crawler->selectLink($linkText)->link();
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException(sprintf("The link '%s' is not found on page '%s'.", $linkText, $this->getRequest()->getPathInfo()));
        }

        return $this->click($link);
    }

    public function signin($username, $passwd = null)
    {
        $this->setServerParameters(array(
            'PHP_AUTH_USER' => $username,
            'PHP_AUTH_PW'   => (null === $passwd) ? $username : $passwd,
        ));
    }
}
