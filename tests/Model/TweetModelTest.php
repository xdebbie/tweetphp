<?php

use PHPUnit\Framework\TestCase;

class TweetModelTest extends TestCase
{
    /**
     * @test
     */
    public function we_can_select_all_tweets()
    {
        // Given there are some tweets in the database
        $pdo = new PDO("mysql:host=localhost;dbname=twitter_test;charset=utf8;port=8889", "root", "root", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $pdo->query('DELETE FROM tweet');

        $pdo->query('INSERT INTO tweet SET author = "Deborah", content = "My test tweet", published_at = NOW()');
        $pdo->query('INSERT INTO tweet SET author = "Deborah Two", content = "My second test tweet", published_at = NOW()');
        $pdo->query('INSERT INTO tweet SET author = "Deborah Three", content = "My third test tweet", published_at = NOW()');

        // When I call the method findAll on my TweetModel
        $model = new \Twitter\Model\TweetModel($pdo);
        $result = $model->findAll();

        // Then I should find all the tweets (3)
        $this->assertIsArray($result);
    }
}
