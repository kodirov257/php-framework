<?php
/**
 * @var Framework\Template\PhpRenderer $this
 * @var string $name
 */
?>

<?php $this->extend = 'layout/columns'; ?>

<?php $this->params['title'] = 'Cabinet'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active">Cabinet</li>
    </ol>
</nav>

<h1>Cabinet of <?= htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE) ?></h1>