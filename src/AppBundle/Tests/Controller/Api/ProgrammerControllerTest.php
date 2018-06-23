<?php
namespace AppBundle\Tests\Controller\Api;

use AppBundle\Test\ApiTestCase;
use GuzzleHttp\Message\Response;

class ProgrammerControllerTest extends ApiTestCase
{
    public function testPOST()
    {
        $data = array(
            'nickname' => "ObjectOrienter",
            "avatarNumber" => 5,
            'tagLine' => 'a test dev!'
        );

        $response = $this->client->post('/api/programmers',[
            'body' => json_encode($data)
        ]);

        $this->writeResponse($response);
        $this->assertEquals(201,$response->getStatusCode());
        $data = json_decode($response->getBody(),true);
        $this->assertEquals("/api/programmers/ObjectOrienter",$response->getHeader("Location"));
        $this->assertEquals($data['nickname'],"ObjectOrienter");

        $programmerUrl = $response->getHeader("Location");
        $response = $this->client->get($programmerUrl);
        $this->assertEquals(200,$response->getStatusCode());

        $response = $this->client->get('/api/programmers');
        $this->assertEquals(200,$response->getStatusCode());

    }

    public function testGETProgrammer()
    {
        $this->createProgrammer([
            'nickname' => 'UnitTester',
            'avatarNumber' => 3
        ]);

        $response = $this->client->get('/api/programmers/UnitTester');
        $this->assertEquals(200,$response->getStatusCode());
        $data = $response->json();
        $this->assertEquals([
            'nickname',
            'avatarNumber',
            'powerLevel',
            'tagLine'
        ],array_keys($data));
    }

    public function writeResponse($response)
    {
        $fp = fopen("test.html","w");
        fwrite($fp, $response);
        fclose($fp);
    }

}