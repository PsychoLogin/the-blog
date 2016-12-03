<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        PsyLogin - Blog
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
    <?= $this->Html->css('psylogin.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<nav class="top-bar expanded" data-topbar role="navigation">
    <ul class="title-area large-4 medium-4 columns">
        <li class="name">
            <?php echo $this->Html->link(
            $this->Html->image('/webroot/img/psylogin.logo.V2.white.png', array('width'=>'200px')), '/', array('escape'
            => false));?>
        </li>
    </ul>
    <div class="top-bar-section">
        <ul class="right">
            <?php if ($loggedIn): ?>
            <li>
                <ul class="dropdown-custom clearfix"><a href="#">Article</a>
                    <li><?php echo $this->Html->link('Artikel schreiben','/articles/add'); ?></li>
                    <li><?php echo $this->Html->link('Meine Artikel','/articles'); ?></li>
                </ul>
            </li>

            <li><?php echo $this->Html->link('Logout','/users/logout'); ?></li>
            <?php else: ?>
            <li><?php echo $this->Html->link('Login','/users/login'); ?></li>
            <li><?php echo $this->Html->link('New Account','/users/add'); ?></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
<?= $this->Flash->render() ?>
<div class="container clearfix">
    <?= $this->fetch('content') ?>
</div>
<footer>
</footer>
</body>
</html>
