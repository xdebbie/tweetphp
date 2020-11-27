<?php

namespace Twitter\Model;

use PDO;

class TweetModel
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll()
    {
        // 3. Recover the data sent by the db
        return $this->pdo
            ->query("SELECT t.* FROM tweet t")
            ->fetchAll();
    }

    public function insert(string $author, string $content)
    {
        $request = $this->pdo->prepare('INSERT INTO tweet SET author = :author, content = :content, published_at = NOW()');
        $request->execute([
            'author' => $author,
            'content' => $content
        ]);

        return $this->pdo->lastInsertId();
    }

    public function remove(int $id)
    {
        $query = $this->pdo->prepare('DELETE FROM tweet WHERE id = :id');
        $query->execute([
            'id' => $id,
        ]);
    }

    public function find(int $id)
    {
        $query = $this->pdo->prepare('SELECT t.* FROM tweet t WHERE id = :id');
        $query->execute([
            'id' => $id,
        ]);

        return $query->fetch();
    }

    public function findByContent(string $content): array
    {
        $request = $this->pdo->prepare('SELECT t.* FROM tweet t WHERE content = :content');
        $request->execute([
            'content' => "This is a super tweet"
        ]);

        return $request->fetchAll();
    }
}
