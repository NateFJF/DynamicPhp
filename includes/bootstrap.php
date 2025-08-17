<?php
// Start session for wishlist
session_start();

// Composer autoload
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/utils.php';

// Twig loader & env
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
$twig = new \Twig\Environment($loader, [
    'cache' => false,
    'autoescape' => 'html',
]);

// register the PHP function for Twig
$twig->addFunction(new \Twig\TwigFunction('category_name', 'category_name'));

// price filter (WIP)
$twig->addFilter(new \Twig\TwigFilter('price', fn($n) => '€' . number_format($n, 2, '.', ',')));

// Helper for timezone-aware greeting
function get_greeting(string $tz = 'Europe/Malta'): string {
    $dt = new DateTime('now', new DateTimeZone($tz));
    $h = (int)$dt->format('G');
    if ($h < 12) return 'Good Morning';
    if ($h < 18) return 'Good Afternoon';
    return 'Good Evening';
}