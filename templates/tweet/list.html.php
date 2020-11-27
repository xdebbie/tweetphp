<ul>
    <?php foreach ($variables['tweets'] as $tweet) : ?>
        <li><?= $tweet['content'] ?></li>
    <?php endforeach ?>
</ul>