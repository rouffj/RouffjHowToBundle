<?php

namespace Rouffj\Bundle\HowToBundle\Tests\Doctrine;

use Rouffj\Bundle\HowToBundle\Tests\WebTestCase;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\UnitOfWork;
use Rouffj\Bundle\HowToBundle\Tests\Doctrine\Fixtures\Internal\Article;
use Rouffj\Bundle\HowToBundle\Tests\Doctrine\Fixtures\Internal\ArticleBis;

class InternalTest extends WebTestCase
{
    public function testHowDoctrineInsertNewEntityWithPostInsertIdIntoDatabase()
    {
        $em = $this->client->getContainer()->get('doctrine')->getManager();
        $uow = $em->getUnitOfWork();
        $article = new ArticleBis();
        $article->title = 'title 1';
        $this->assertEquals(UnitOfWork::STATE_NEW, $uow->getEntityState($article), 'An entity not persisted or not fetched via Doctrine should have the STATE_NEW');

        $em->persist($article);
        // The listeners listening For Events::prePersist event will be notified.
        $this->assertEquals(UnitOfWork::STATE_MANAGED, $uow->getEntityState($article)); // entity status change
        $scheduledInserts = $uow->getScheduledEntityInsertions();
        $this->assertEquals($article, $scheduledInserts[spl_object_hash($article)]); // The entity will be programmed for the next flush
        $identityMap = $uow->getIdentityMap();
        $this->assertFalse(isset($identityMap['Rouffj\Bundle\HowToBundle\Tests\Doctrine\Fixtures\Internal\ArticleBis']), 'Entity is not yet in identityMap because it has a PostInsertId');

        $em->flush();
        // UnitOfWork delegates SQL generation to Persister.
        $scheduledInserts = $uow->getScheduledEntityInsertions();
        $this->assertFalse(isset($scheduledInserts[spl_object_hash($article)])); // The entity is removed from scheduled insert
        $this->assertEquals(array('id' => 1), $uow->getEntityIdentifier($article));
        $identityMap = $uow->getIdentityMap();
        $this->assertEquals(array(1 => $article), $identityMap['Rouffj\Bundle\HowToBundle\Tests\Doctrine\Fixtures\Internal\ArticleBis']);
        // The listeners for Events::PostPersist event will be notified
    }

    public function testHowDoctrineInsertNewEntityWithPreInsertIdIntoDatabase()
    {
        $em = $this->client->getContainer()->get('doctrine')->getManager();
        $uow = $em->getUnitOfWork();
        $article = new Article('2013-01-01', 1);
        $article->title = 'title 1';
        $this->assertEquals(UnitOfWork::STATE_NEW, $uow->getEntityState($article), 'An entity not persisted or not fetched viaDoctrine should have the STATE_NEW');

        $em->persist($article);
        // The listeners listening For Events::prePersist event will be notified.
        // When id is not a post insert generated value, the id generator used by entity will be fired.
        $this->assertEquals(UnitOfWork::STATE_MANAGED, $uow->getEntityState($article)); // entity status change
        $this->assertEquals(array('articleNumber' => 1, 'date' => '2013-01-01'), $uow->getEntityIdentifier($article)); // Entity id is added into entityIdentifiers map ONLY if its id is not a post insert generated value.
        $scheduledInserts = $uow->getScheduledEntityInsertions();
        $this->assertEquals($article, $scheduledInserts[spl_object_hash($article)]); // The entity will be programmed for the next flush
        $identityMap = $uow->getIdentityMap();
        $this->assertEquals(array('2013-01-01 1' => $article), $identityMap['Rouffj\Bundle\HowToBundle\Tests\Doctrine\Fixtures\Internal\Article'], 'Entity is added to identity map after persist ONLY if its id is not a post insert generated value');

        $em->flush();
        // UnitOfWork delegates SQL generation to Persister.
        $scheduledInserts = $uow->getScheduledEntityInsertions();
        $this->assertFalse(isset($scheduledInserts[spl_object_hash($article)])); // The entity is removed from scheduled insert
        // The listeners for Events::PostPersist event will be notified
    }
}
