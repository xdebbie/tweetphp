<?php

namespace Twitter\Model;

use Jajo\JSONDB;

class JsonTweetModel
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
        ]);

        return $id;
    }

    public function findAll(): array
    {

        return $this->jsonDb->select()
            ->from('tweet.json')
            ->get();
    }
}
