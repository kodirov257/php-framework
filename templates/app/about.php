<?php
/**
 * @var Framework\Template\PhpRenderer $this
 */
?>

<?php $this->extend('layout/columns'); ?>

<?php $this->beginBlock('title'); ?>About<?php $this->endBlock(); ?>

<?php $this->beginBlock('meta'); ?>
    <meta name="description" content="About page description" />
<?php $this->endBlock(); ?>

<?php $this->beginBlock('breadcrumbs'); ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active">About</li>
        </ol>
    </nav>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('main'); ?>
    <h1>About the site</h1>
<?php $this->endBlock(); ?>