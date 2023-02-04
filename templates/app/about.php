<?php
/**
 * @var Framework\Template\PhpRenderer $this
 */
?>

<?php $this->extend('layout/default'); ?>

<?php $this->params['title'] = 'About'; ?>

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

<h1>About the site</h1>