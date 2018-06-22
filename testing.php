<?php
    require  __DIR__."/vendor/autoload.php";

    $client = new \GuzzleHttp\Client([
       'base_url' => 'http://localhost:8000',
       'defaults' => [
           'exceptions' =>false
       ]
    ]);

    $response = $client->post('/api/programmers');

    echo $response;

    $fp = fopen("test.html","w");
    fwrite($fp, $response);
    fclose($fp);
    echo "\n\n";