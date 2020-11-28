<h1><?php $name ?></h1>

<ul>
    <?php foreach ($tweets as $tweet) : ?>
        <li><?= $tweet->content ?></li>
    <?php endforeach; ?>
</ul>