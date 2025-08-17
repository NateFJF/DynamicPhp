<?php
require_once __DIR__ . '/../includes/bootstrap.php';
require_once __DIR__ . '/../includes/utils.php';

$code = $_GET['code'] ?? '';
$product = $code ? find_product($code) : null;
if (!$product) { http_response_code(404); exit('Product not found'); }

echo $twig->render('product_details.html.twig', [
    'title' => $product['name'],
    'product' => $product,
    'categories' => all_categories(),
]);
