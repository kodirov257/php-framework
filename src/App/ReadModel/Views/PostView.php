<?php

namespace App\ReadModel\Views;

class PostView
{
    public int $id;
    public \DateTimeImmutable $date;
    public string $title;
    public string $content;
}
