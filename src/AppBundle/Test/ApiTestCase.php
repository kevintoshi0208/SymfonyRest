<?php
/**
 * Created by PhpStorm.
 * User: black
 * Date: 2018/6/23
 * Time: 下午 02:34
 */

namespace AppBundle\Test;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ApiTestCase extends KernelTestCase
{
    private static $staticClient;
    protected $client;

    /**
     * This method is called before the first test of this test class is run.
     *
     * @since Method available since Release 3.4.0
     */
    public static function setUpBeforeClass()
    {
        self::$staticClient = new Client([
            'base_url' => 'http://localhost:8000',
            'defaults' => [
                'exceptions' => false
            ]
        ]);

        self::bootKernel();
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     */
    protected function setUp()
    {
        $this->client = self::$staticClient;
        $this->purgeDatabase();
    }

    protected function tearDown()
    {

    }

    protected function getService($id)
    {
        return self::$kernel->getContainer()
            ->get($id);
    }

    protected function purgeDatabase()
    {
        $purge = new ORMPurger($this->getService("doctrine")->getManager());
        $purge->purge();
    }
}