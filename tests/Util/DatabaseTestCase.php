<?php

namespace Tests\Util;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * The DatabaseTestCase extends Symfony's KernelTestCase
 * and makes sure that the default database is empty before
 * every single one of its unit tests is executed.
 */
class DatabaseTestCase extends KernelTestCase
{
    /**
     * @var EntityManager
     */
    protected $em;

    protected function setUp()
    {
        self::bootKernel();

        $this->em = self::$kernel->getContainer()
            ->get('doctrine.orm.default_entity_manager');

        (new ORMPurger($this->em))->purge();
    }
}
