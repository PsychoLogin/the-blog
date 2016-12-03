<h1>Blog articles</h1>

<?php foreach ($articles as $article): ?>
    <article>
        <h2><?= $article->title ?></h2>
        <p>
            <?= $article->created->format('d. F Y') ?>
            <br><?= $article->user->username ?>

        </p>
        <p><?= $article->body ?></p>
    </article>
<?php endforeach; ?>
<h1>Users</h1>
<ul>
<?php foreach ($users as $user): ?>
    <li><?php echo $this->Html->link($user->username,'/?userid='.$user->id); ?></li>
<?php endforeach; ?>
</ul>



