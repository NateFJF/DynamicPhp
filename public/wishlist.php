<?php
require_once __DIR__ . '/../includes/bootstrap.php';
require_once __DIR__ . '/../includes/utils.php';

$action = $_POST['action'] ?? null;
$code = $_POST['code'] ?? null;

if ($action === 'add' && $code) {
    wishlist_add($code);
} elseif ($action === 'remove' && $code) {
    wishlist_remove($code);
}

$items = wishlist_items();

echo $twig->render('wishlist.html.twig', [
    'title' => 'Wishlist',
    'items' => $items,
]);