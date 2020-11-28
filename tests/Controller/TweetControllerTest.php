<?php

use Jajo\JSONDB;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;
use Test\PDOFactory;
use Twitter\Controller\TweetController;
use Twitter\Http\Request;
use Twitter\Model\JsonTweetModel;
use Twitter\Model\TweetModel;
use Twitter\Model\TweetModelInterface;

class TweetControllerTest extends TestCase
{
    protected PDO $pdo;
    protected TweetModelInterface $model;
    protected TweetController $controller;

    protected function setUp(): void
    {
        $this->pdo = PDOFactory::getPdo();
        // $this->jsonDb = new JSONDB(__DIR__ . '/../../json');

        $this->pdo->query('DELETE FROM tweet');
        // $this->jsonDb->delete()
        //     ->from('tweet.json')
        //     ->trigger();

        $this->model = new TweetModel($this->pdo);
        $this->controller = new TweetController($this->model);
    }

    /**
     * @test
     */
    public function we_can_access_a_list_of_tweets()
    {
        // Given there are 3 tweets in the database
        $this->model->insert("Deborah", "My test tweet");
        $this->model->insert("Deborah", "My second test tweet");
        $this->model->insert("Deborah", "My third test tweet");

        // When I call the controller
        $response = $this->controller->listTweets();

        // // Then it should give us HTML with 3 tweets
        // $this->assertStringContainsString('<ul>', $response->getContent());

        // // And the content should contain 3 <li>
        // $crawler = new Crawler($response->getContent());
        // $count = $crawler->filter('li')->count();
        // $this->assertEquals(3, $count);

        // And the content contains tweets content
        $this->assertStringContainsString("My test tweet", $response->getContent());
        $this->assertStringContainsString("My second test tweet", $response->getContent());
        $this->assertStringContainsString("My third test tweet", $response->getContent());
    }

    /**
     * @test
     */
    public function we_can_display_a_tweet_form()
    {
        // When we call our controller
        $response = $this->controller->displayForm();

        // Then it displays the form
        $crawler = new Crawler($response->getContent());

        $form = $crawler->filter('form');
        $this->assertEquals('save.php', $form->attr('action'));
        $this->assertEquals('post', $form->attr('method'));

        $count = $form->count();
        $this->assertEquals(1, $count);

        $count = $crawler->filter('textarea')->count();
        $this->assertEquals(1, $count);
    }

    /**
     * @test
     */
    public function we_can_save_a_tweet()
    {
        // Given the user sends a POST request to the server
        // with a data named content with the value "This is a super tweet"
        $request = new Request([
            'content' => "This is a super tweet"
        ]);

        // When I call my controller
        $response = $this->controller->saveTweet($request);

        // Then we should find on the db the new tweet
        $tweet = $this->model->findByContent("This is a super tweet");

        $this->assertIsObject($tweet);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('/', $response->getHeader('Location'));
    }

    /**
     * @test
     */
    public function we_can_delete_a_tweet()
    {
        // Given a tweet exists
        // $this->pdo->query('INSERT INTO tweet SET author = "Deborah", content = "My test tweet", published_at = NOW()');
        $id = $this->model->insert("Deborah", "My test tweet");
        // $id = $this->pdo->lastInsertId();

        // and we have a request with a param id of the tweet
        $request = new Request([
            'id' => $id
        ]);

        // When I call the controller with the good method
        $response = $this->controller->delete($request);

        // Then the tweet should not be found in the database
        // $query = $this->pdo->prepare('SELECT t.* FROM tweet t WHERE id = :id');
        // $query->execute([
        //     'id' => $id,
        // ]);

        // $this->assertEquals(0, $query->rowCount());

        $query = $this->model->find($id);
        $this->assertFalse($query);

        // and we should be redirected to /
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('/', $response->getHeader('Location'));
    }
}
