<?php
/**
 * @var Framework\Template\PhpRenderer $this
 */
?>

<?php $this->extend('layout/default'); ?>

<?php $this->params['title'] = 'About'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active">About</li>
    </ol>
</nav>

<h1>About the site</h1>