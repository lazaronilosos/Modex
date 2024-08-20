<?php
// Autoload Composer dependencies
require_once __DIR__.'/../vendor/autoload.php'; // Adjust path to where your autoload.php is located

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Define the location of your Twig templates
$loader = new FilesystemLoader(__DIR__ . '/../src/view');
?>