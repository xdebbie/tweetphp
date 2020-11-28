<?php

namespace Twitter\Model;

class LogTweetModel extends TweetModel
{
    public function findAll(): array
    {
        return $this->db
            ->query("SELECT t.* FROM tweet t")
            ->fetchAll();
    }
}
