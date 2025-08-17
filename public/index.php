<?php
require_once __DIR__ . '/../includes/bootstrap.php';
require_once __DIR__ . '/../includes/utils.php';

$greeting = get_greeting('Europe/Malta');
$timeOfDay = strtolower(explode(' ', $greeting)[1]); // morning/afternoon/evening

echo $twig->render('home.html.twig', [
    'title' => 'Home',
    'time_of_day' => $timeOfDay,
    'categories' => all_categories(),
]);