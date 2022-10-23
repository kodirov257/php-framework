<?php

$name = $_GET['name'] ?? 'Guest';

header('X-Developer: Abdurakhmon Kodirov');
echo 'Hello, ' . $name . '!';