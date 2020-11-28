<?php

namespace Twitter\Model;

use DateTime;
use Jajo\JSONDB;

class JsonTweetModel implements TweetModelInterface
{
    protected JSONDB $jsonDb;

    public function __construct(JSONDB $jsonDb)
    {
        $this->jsonDb = $jsonDb;
    }

    public function insert(string $author, string $content)
    {
        $id = uniqid();

        $this->jsonDb->insert('tweet.json', [
            'author' => $author,
            'content' => $content,
            'id' => $id,
            'published_at' => new DateTime()
        ]);

        return $id;
    }

    public function find($id)
    {
        $tweets = $this->jsonDb
            ->select()
            ->from('tweet.json')
            ->where(['id' => $id])
            ->get();

        return isset($tweets[0]) ? (object) $tweets[0] : false;
    }

    public function findAll(): array
    {

        return $this->jsonDb->select()
            ->from('tweet.json')
            ->get();
    }

    public function remove($id)
    {
        $this->jsonDb
            ->delete()
            ->where(['id' => $id])
            ->trigger();
    }

    public function findByContent(string $content)
    {
        $tweets = $this->jsonDb
            ->select()
            ->from('tweet.json')
            ->where(['content' => $content])
            ->get();

        return isset($tweets[0]) ? (object) $tweets[0] : false;
    }
}
