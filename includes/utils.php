<?php
require_once __DIR__ . '/product_data.php';

function all_categories(): array { global $CATEGORIES; return $CATEGORIES; }
function all_products(): array { global $PRODUCTS; return $PRODUCTS; }

function find_product(string $code): ?array {
    foreach (all_products() as $p) {
        if ($p['code'] === $code) return $p;
    }
    return null;
}

function products_by_category(?string $cat): array {
    $items = all_products();
    if (!$cat) return $items;
    return array_values(array_filter($items, fn($p) => $p['category'] === $cat));
}

function category_name(string $code): string {
    $cats = all_categories();
    return $cats[$code] ?? $code;
}

// Wishlist helpers using $_SESSION
function wishlist_init(): void {
    if (!isset($_SESSION['wishlist'])) $_SESSION['wishlist'] = [];
}

function wishlist_add(string $code): void {
    wishlist_init();
    if (!in_array($code, $_SESSION['wishlist'], true)) {
        $_SESSION['wishlist'][] = $code;
    }
}

function wishlist_remove(string $code): void {
    wishlist_init();
    $_SESSION['wishlist'] = array_values(array_filter(
        $_SESSION['wishlist'], fn($c) => $c !== $code
    ));
}

function wishlist_items(): array {
    wishlist_init();
    return array_values(array_filter(all_products(), fn($p) => in_array($p['code'], $_SESSION['wishlist'], true)));
}