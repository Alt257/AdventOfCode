<?php

// Load our autoloader
require_once __DIR__ . '\vendor\autoload.php';
require_once __DIR__ . '\src\Service\AdventOfCodeService.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Specify our Twig templates location
$loader = new FilesystemLoader(__DIR__ . '\templates');

// Instantiate our Twig
$twig = new Environment($loader);