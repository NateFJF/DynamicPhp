<?php
require_once __DIR__ . '/../includes/bootstrap.php';

$team = [
    [ 'name' => 'Adam Gatt', 'photo' => 'team1.jpg', 'bio' => 'Store manager with 10+ years in consumer electronics.' ],
];

echo $twig->render('about.html.twig', [
    'title' => 'About Us',
    'team' => $team,
]);