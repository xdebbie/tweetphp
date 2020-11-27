<?php

use Twitter\Controller\TweetController;
use Twitter\Http\Request;
use Twitter\Model\TweetModel;

require __DIR__ . '/vendor/autoload.php';

$pdo = new PDO("mysql:host=localhost;dbname=twitter_test;charset=utf8;port=8889", "root", "root", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$model = new TweetModel($pdo);
$controller = new TweetController($model);

$request = new Request($_REQUEST);

$response = $controller->saveTweet($request);

$response->send();
