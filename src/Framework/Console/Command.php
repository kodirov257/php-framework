<?php

namespace Framework\Console;

interface Command
{
    public function execute(Input $input, Output $output): void;
}