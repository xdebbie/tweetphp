<?php

namespace Twitter\Controller;

use Twitter\Http\Request;
use Twitter\Http\Response;

class HelloController {
    public function sayHello(Request $request) {
        $name = $request->getParam('name', 'World');

        $response = new Response;
        $response->setStatusCode(200);
        // Code ? 200 ? 404 ?
        // http_response_code(200);

        // Headers --> Content-Type: text/html
        $response->setHeaders([
        'Content-Type' => 'text/html',
        'Lang' => 'en-EN'
        ]);
        // header("Content-Type: text/html");
        // header("Lang: en-EN");

        //Content
        $response->setContent("Hello $name");

        return $response;
    }
}