<?php
/**
 * @var Framework\Template\PhpRenderer $this
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?= $this->params['title'] ?? '' ?> - App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <style>
        /*body { padding-top: 70px; }*/
        h1 { margin-top: 0 }
        .app { display: flex; min-height: 100vh; flex-direction: column; }
        .app-content { flex: 1; }
        /*.app-footer { padding-bottom: 1em; }*/
    </style>
</head>
<body class="app">
<header class="p-3 text-bg-dark">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="/" class="nav-link px-2 text-secondary ">Application</a></li>
            </ul>

            <div class="text-end">
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="/about" class="nav-link px-2 text-white"><i class="bi bi-door-open"></i> About</a></li>
                    <li><a href="/cabinet" class="nav-link px-2 text-white"><i class="bi bi-person"></i> Cabinet</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>

<div class="app-content pt-4">
    <main class="container">
        <?= $content ?>
    </main>
</div>

<footer class="text-center text-lg-start bg-light text-muted">
    <div class="container">
        <div class="text-left p-4" style="background-color: rgba(0, 0, 0, 0);">
            &copy; 2023 - My App
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>