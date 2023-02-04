<?php
/**
 * @var Framework\Template\PhpRenderer $this
 */
?>

<?php $this->extend('layout/default'); ?>

<?php $this->beginBlock('title'); ?>Hello<?php $this->endBlock(); ?>

<?php $this->beginBlock('meta'); ?>
<meta name="description" content="Home page description" />
<?php $this->endBlock(); ?>

<div class="jumbotron">
    <h1>Hello!</h1>
    <p>
        Congratulations! You have successfully created your application.
    </p>
</div>