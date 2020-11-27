<?php

require_once __DIR__ . '/vendor/autoload.php';

use Twitter\Controller\HelloController;
use Twitter\Controller\TweetController;
use Twitter\Http\Request;
use Twitter\Http\Response;
use Twitter\Model\TweetModel;

// 1. Set a request
// Side note: we cannot test a file with a superglobal
$request = new Request($_REQUEST);

// 2. Manage the request and create a response
// $controller = new HelloController;
// $response = $controller->sayHello($request);
$pdo = new PDO("mysql:host=localhost;dbname=twitter_test;charset=utf8;port=8889", "root", "root", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$model = new TweetModel($pdo);
$controller = new TweetController($model);

$response = $controller->listTweets();

// 3. Send the response to the browser 
$response->send();
