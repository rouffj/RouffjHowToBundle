<?php

namespace Rouffj\Bundle\HowToBundle\Tests\Doctrine;

use Rouffj\Bundle\HowToBundle\Tests\WebTestCase;
use Rouffj\Bundle\HowToBundle\Tests\Doctrine\Fixtures\Locking\Document;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\OptimisticLockException;

class LockingTest extends WebTestCase
{
    public function testHowToUseOptimisticLockWithVersionMapping()
    {
        $em = $this->client->getContainer()->get('doctrine')->getManager();

        // We create a new document, its version after flush is automatically set to 1.
        $doc = new Document('id-foo', 'title');
        $doc->content = 'content';
        $em->persist($doc);
        $this->assertEquals(null, $doc->version);
        $em->flush();
        $this->assertEquals(1, $doc->version);

        // We emulate that 9 other people updated the document since its creation by us.
        $em->getConnection()->executeQuery('UPDATE Document SET version = ?, content = ?', array(10, 'content 10'));

        // We are trying to update our local version of the document not refreshed since its creation.
        try {
            $this->assertEquals(1, $doc->version);
            $doc->content = 'content 2';
            $doc->title = 'title 2';
            $em->flush();
        } catch(OptimisticLockException $e) {
            $this->assertTrue(true, 'An OptimisticLockException should be raised because our document version is not up-to-date');

            // We should recreate an other entity manager because an exception has been thrown.
            $this->client->getContainer()->get('doctrine')->resetManager();
            $em = $this->client->getContainer()->get('doctrine')->getManager();

            $this->assertSame($doc, $v1Doc = $e->getEntity());
            $v10Doc = $em->getRepository('RouffjHowToDoctrine:Locking\Document')->find('id-foo');
            $this->assertEquals(1, $v1Doc->version);
            $this->assertEquals(10, $v10Doc->version);

            // Now we can apply to updated document: 1) All our local changes. 2) Only some of local changes. 3) None of local changes.
            $v10Doc->title = $v1Doc->title;
            $em->flush();

            $v11Doc = $em->getRepository('RouffjHowToDoctrine:Locking\Document')->find('id-foo');
            $this->assertEquals('title 2', $v11Doc->title);
            $this->assertEquals('content 10', $v11Doc->content);
            $this->assertEquals(11, $v10Doc->version, 'The version should change after having resolved the conflicts.');
        }
    }
}
