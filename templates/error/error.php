<?php
/**
 * @var \Framework\Template\Php\PhpRenderer $this
 */
?>

<?php $this->extend('layout/default'); ?>

<?php $this->beginBlock('title'); ?>500 - Server Error<?php $this->endBlock(); ?>

<?php $this->beginBlock('breadcrumbs'); ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= $this->encode($this->path('home')) ?>">Home</a></li>
            <li class="breadcrumb-item active">Error</li>
        </ol>
    </nav>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('content'); ?>
    <h1>500 - Server Error</h1>
<?php $this->endBlock(); ?>