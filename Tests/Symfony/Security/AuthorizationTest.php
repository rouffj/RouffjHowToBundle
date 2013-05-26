<?php

namespace Rouffj\Bundle\HowToBundle\Tests\Symfony\Security;

use Rouffj\Bundle\HowToBundle\Tests\WebTestCase;

class AuthorizationTest extends WebTestCase
{
    public function testHowToUseVoterForRequestBasedAuthorization()
    {
        // case 1
        $crawler = $this->client->request('GET', '/howto/security/voter/1');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), 'The homepage should be accessible for non signin users');

        $this->client->signin('user1', 'user1pass');
        $this->client->openLink('Join the private beta', $crawler);

        $this->assertEquals('user1', $this->client->getContainer()->get('security.context')->getToken()->getUser()->getUsername(), 'The user should be connected');
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode(), 'But should have access denied because he is not in "authorized login" list given to BetaVoter');

        // case 2
        $crawler = $this->client->request('GET', '/howto/security/voter/1');

        $this->client->signin('user2', 'user2pass');
        $this->client->openLink('Join the private beta', $crawler);

        $this->assertEquals('user2', $this->client->getContainer()->get('security.context')->getToken()->getUser()->getUsername(), 'The user should be connected');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), 'The user should have access granted because HE IS in "authorized login" list given to BetaVoter');
    }
}
