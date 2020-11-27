<?php

use Jajo\JSONDB;
use PHPUnit\Framework\TestCase;
use Twitter\Model\JsonTweetModel;

class JsonTweetModelTest extends TestCase
{
    protected JSONDB $jsonDb;
    protected JsonTweetModel $model;

    protected function setUp(): void
    {
        $this->jsonDb = new JSONDB(__DIR__ . '/../../json');
        $this->model = new JsonTweetModel($this->jsonDb);

        $this->jsonDb->delete()
            ->from('tweet.json')
            ->trigger();
    }

    /**
     * @test
     */
    public function we_can_find_all_tweets()
    {
        // Given there are 3 tweets in the json file
        $this->jsonDb->insert('tweet.json', [
            'author' => 'Deborah',
            'content' => 'This is my first tweet',
            'id' => uniqid()
        ]);

        $this->jsonDb->insert('tweet.json', [
            'author' => 'Deborah too',
            'content' => 'What a day',
            'id' => uniqid()
        ]);

        $this->jsonDb->insert('tweet.json', [
            'author' => 'Deborah again',
            'content' => 'Need a drink',
            'id' => uniqid()
        ]);

        // When we can findAll() on our model
        $tweets = $this->model->findAll();

        // Then it will return 3 tweets
        $this->assertIsArray($tweets);
        $this->assertCount(3, $tweets);
    }

    /**
     * @test
     */
    public function we_can_insert_a_tweet()
    {
        // Given

        // When I use insert() on my model
        $id = $this->model->insert("Deborah", "This is a super tweet");

        // Then
        $this->assertNotNull($id);
        // and I should find a tweet with $id
        $tweets = $this->jsonDb->select()
            ->from('tweet.json')
            ->where(['id' => $id])
            ->get();

        $tweet = $tweets[0];

        // and the tweet should contain Deborah // this is a super tweet
        $this->assertIsArray($tweet);
        $this->assertEquals('Deborah', $tweet['author']);
        $this->assertEquals('This is a super tweet', $tweet['content']);
    }
}
