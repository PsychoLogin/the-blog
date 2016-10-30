<h1>Blog articles</h1>
    <?php foreach ($articles as $article): ?>
        <article>
            <header><?= $article->title ?></header>
            <p><?= $article->body ?></p>
        </article>
    <?php endforeach; ?>