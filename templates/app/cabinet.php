<?php
/**
 * @var \Framework\Template\Php\PhpRenderer $this
 * @var string $name
 */
?>

<?php $this->extend('layout/columns'); ?>

<?php $this->beginBlock('title'); ?>Cabinet<?php $this->endBlock(); ?>

<?php $this->beginBlock('breadcrumbs'); ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= $this->encode($this->path('home')) ?>">Home</a></li>
        <li class="breadcrumb-item active">Cabinet</li>
    </ol>
</nav>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('sidebar'); ?>
    <div class="panel panel-default" style="width: 25rem">
        <div class="panel-heading">Cabinet</div>
        <div class="panel-body">
            Cabinet navigation
        </div>
    </div>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('main'); ?>
    <h1>Cabinet of <?= $this->encode($name); ?></h1>
<?php $this->endBlock(); ?>