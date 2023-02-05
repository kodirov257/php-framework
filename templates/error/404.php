<?php
/**
 * @var Framework\Template\PhpRenderer $this
 */
?>

<?php $this->extend('layout/default'); ?>

<?php $this->beginBlock('title'); ?>404 - Not Found<?php $this->endBlock(); ?>

<?php $this->beginBlock('breadcrumbs'); ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= $this->encode($this->path('home')) ?>">Home</a></li>
            <li class="breadcrumb-item active">Error</li>
        </ol>
    </nav>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('content'); ?>
    <h1>404 - Not Found</h1>
<?php $this->endBlock(); ?>