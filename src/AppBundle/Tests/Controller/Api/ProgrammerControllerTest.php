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
        /**  @var Response $response */
        $this->assertEquals("/api/programmers/ObjectOrienter",$response->getHeader("Location"));
        $this->assertEquals('nickname',"ObjectOrienter");

        $programmerUrl = $response->getHeader("Location");
        $response = $this->client->get($programmerUrl);


        $this->assertEquals(200,$response->getStatusCode());


        $response = $this->client->get('/api/programmers');

        $this->assertEquals(200,$response->getStatusCode());

    }

    public function writeResponse($response)
    {
        $fp = fopen("test.html","w");
        fwrite($fp, $response);
        fclose($fp);
    }

}