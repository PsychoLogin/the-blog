<h1>Blog articles</h1>
<h1><?php echo $this->Html->link('New Article','/articles/add'); ?></h1>
<?php foreach ($articles as $article): ?>
    <article>
        <header><?= $article->title ?></header>
        <p><?= $article->body ?></p>
    </article>
<?php endforeach; ?>
<h1>Users</h1>
<ul>
<?php foreach ($users as $user): ?>
    <li><?php echo $this->Html->link($user->username,'/?userid='.$user->id); ?></li>
<?php endforeach; ?>
</ul>



