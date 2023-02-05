<?php
/**
 * @var \Framework\Template\Php\PhpRenderer $this
 * @var Throwable $exception
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Error</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?= $this->renderBlock('meta'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>

<div class="app-content pt-4">
    <main class="container">
        <h1>Exception: <?= $this->encode($exception->getMessage()) ?></h1>

        <p>Code: <?= $this->encode($exception->getCode()) ?></p>
        <p><?= $this->encode($exception->getFile()) ?> on line <?= $this->encode($exception->getLine()) ?></p>
        <?php foreach ($exception->getTrace() as $trace): ?>
            <?php if (isset($trace['file']) && $trace['line']): ?>
                <p><?= $this->encode($trace['file']) ?> on line <?= $this->encode($trace['line']) ?></p>
            <?php endif; ?>
        <?php endforeach; ?>
    </main>
</div>

</body>
</html>