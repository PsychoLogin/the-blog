<h1>Blog articles</h1>
<h1><a href="/articles/add">New Article</a></h1>
<?php foreach ($articles as $article): ?>
    <article>
        <header><?= $article->title ?></header>
        <p><?= $article->body ?></p>
    </article>
<?php endforeach; ?>
<h1>Users</h1>
<ul>
<?php foreach ($users as $user): ?>
    <li><a href="/?userid=<?= $user->id?>"><?= $user->username ?></a></li>
<?php endforeach; ?>
</ul>



