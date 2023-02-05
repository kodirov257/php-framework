<?php
/**
 * @var Framework\Template\PhpRenderer $this
 * @var App\ReadModel\Views\PostView $post
 */

$this->extend('layout/default');
?>

<?php $this->beginBlock('title'); ?><?= $this->encode($post->title); ?><?php $this->endBlock(); ?>

<?php $this->beginBlock('meta'); ?>
    <meta name="description" content="<?= $this->encode($post->title); ?>" />
<?php $this->endBlock(); ?>

<?php $this->beginBlock('breadcrumbs'); ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= $this->encode($this->path('home')) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?= $this->encode($this->path('blog')) ?>">Blog</a></li>
        <li class="breadcrumb-item active"><?= $this->encode($post->title); ?></li>
    </ol>
</nav>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('content'); ?>
    <h1><?= $this->encode($post->title); ?></h1>

        <div class="panel panel-default">
            <div class="panel-heading">
                <?= $post->date->format('Y-m-d') ?>
            </div>
            <div class="panel-body"><?= nl2br($this->encode($post->content)) ?></div>
        </div>
<?php $this->endBlock(); ?>