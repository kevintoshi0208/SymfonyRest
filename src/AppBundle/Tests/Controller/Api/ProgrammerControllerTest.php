<?php
namespace AppBundle\Tests\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class ProgrammerControllerTest extends TestCase
{
    public function testPOST()
    {
        $client = new \GuzzleHttp\Client([
            'base_url' => 'http://localhost:8000',
            'defaults' => [
                'exceptions' =>false
            ]
        ]);
        $nickname = "ObjectOrienter".rand(0,999);
        $data = array(
            'nickname' => $nickname,
            "avatarNumber" => 5,
            'tagLine' => 'a test dev!'
        );
        $response = $client->post('/api/programmers',[
            'body' => json_encode($data)
        ]);

        $this->assertEquals(201,$response->getStatusCode());
        $this->assertTrue($response->hasHeader("Location"));
        $this->assertArrayHasKey('nickname',json_decode($response->getBody(),true));

        $programmerUrl = $response->getHeader("Location");
        $response = $client->get($programmerUrl);

        $this->assertEquals(200,$response->getStatusCode());


        $response = $client->get('/api/programmers');

        $this->assertEquals(200,$response->getStatusCode());

//        $fp = fopen("test.html","w");
//        fwrite($fp, $response);
//        fclose($fp);
//        echo "\n\n";
    }

}