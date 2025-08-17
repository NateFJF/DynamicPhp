<?php
// Start session for wishlist
session_start();

// Composer autoload
require_once __DIR__ . '/../vendor/autoload.php';

// Twig loader & env
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
$twig = new \Twig\Environment($loader, [
    'cache' => false, // set to a folder path for caching in production
    'autoescape' => 'html',
]);

// Global variables required by the brief (fonts/colors handled in CSS)
$twig->addGlobal('site', [
    'name' => 'Moplin Ltd',
]);

// Simple helper for timezone-aware greeting
function get_greeting(string $tz = 'Europe/Malta'): string {
    $dt = new DateTime('now', new DateTimeZone($tz));
    $h = (int)$dt->format('G');
    if ($h < 12) return 'Good morning!';
    if ($h < 18) return 'Good afternoon!';
    return 'Good evening!';
}