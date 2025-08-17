<?php
require_once __DIR__ . '/../includes/bootstrap.php';
require_once __DIR__ . '/../includes/utils.php';

$cat = $_GET['category'] ?? null;
$items = products_by_category($cat);

// Twig function for category name
$twig->addFunction(new \Twig\TwigFunction('category_name', 'category_name'));

echo $twig->render('product_list.html.twig', [
    'title' => 'Products',
    'categories' => all_categories(),
    'products' => $items,
]);