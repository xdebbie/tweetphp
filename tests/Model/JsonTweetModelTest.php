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

        $this->jsonDb->delete()
            ->from('tweet.json')
            ->trigger();

        $this->model = new JsonTweetModel($this->jsonDb);
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
            'id' => uniqid(),
            'published_at' => new DateTime()
        ]);

        $this->jsonDb->insert('tweet.json', [
            'author' => 'Deborah too',
            'content' => 'What a day',
            'id' => uniqid(),
            'published_at' => new DateTime()
        ]);

        $this->jsonDb->insert('tweet.json', [
            'author' => 'Deborah again',
            'content' => 'Need a drink',
            'id' => uniqid(),
            'published_at' => new DateTime()
        ]);

        // When we can findAll() on our model
        $model = new JsonTweetModel($this->jsonDb);
        $resultTweet = $model->findAll();

        // Then it will return 3 tweets
        $this->assertIsArray($resultTweet);
        $this->assertCount(3, $resultTweet);
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
        $tweet = $this->jsonDb->select()
            ->from('tweet.json')
            ->where(['id' => $id])
            ->get();

        // and the tweet should contain Deborah // this is a super tweet
        $this->assertIsArray($tweet);
        $this->assertEquals('Deborah', $tweet[0]['author']);
        $this->assertEquals('This is a super tweet', $tweet[0]['content']);
    }

    /**
     * @test
     */
    public function we_can_find_a_tweet_by_its_id()
    {
        // Given we have a tweet and we know its id on the json file
        $id = uniqid();
        $this->jsonDb->insert('tweet.json', [
            'id' => $id,
            'author' => 'Deborah',
            'content' => '#FreeBritney',
            'published_at' => new DateTime()
        ]);

        // When we call find() on our model
        $tweet = $this->model->find($id);

        // Then we should obtain the tweet
        $this->assertIsObject($tweet);
        $this->assertEquals('Deborah', $tweet->author);
        $this->assertEquals('#FreeBritney', $tweet->content);
    }

    /**
     * @test
     */
    public function we_can_remove_a_tweet()
    {
        // Given we have a tweet in the json file and we know its id
        $id = uniqid();
        $this->jsonDb->insert('tweet.json', [
            'id' => $id,
            'author' => 'Deborah',
            'content' => '#FreeBritney',
            'published_at' => new DateTime()
        ]);

        // When we call remove with id
        $this->model->remove($id);

        // Then we should find nothing if we search for this id
        $tweets = $this->jsonDb
            ->select()
            ->from('tweet.json')
            ->where(['id' => $id])
            ->get();

        $this->assertCount(0, $tweets);
    }

    /**
     * @test
     */
    public function we_can_find_a_tweet_with_its_content()
    {
        // Given
        $content = "#FreeBritney";

        $this->jsonDb->insert('tweet.json', [
            'id' => uniqid(),
            'author' => 'Deborah',
            'content' => $content,
            'published_at' => new DateTime()
        ]);

        // When we call findByContent
        $tweet = $this->model->findByContent($content);

        // Then we should find 1 tweet
        $this->assertIsObject($tweet);
        $this->assertEquals('Deborah', $tweet->author);
        $this->assertEquals($content, $tweet->content);
    }
}
