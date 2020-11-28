<?php


namespace Twitter\Model;


interface TweetModelInterface
{
    public function insert(string $author, string $content);
    public function findAll();
    public function findByContent(string $content);
    public function find(int $id);
    public function remove(int $id);
}
