<?php
// Δημιουργία 100 τυχαίων προϊόντων
$products = [];

$sizes = ["small", "medium", "large"];
$colors = ["red", "blue", "green", "black", "white"];
$brands = ["Nike", "Adidas", "Puma", "Reebok", "Under Armour"];
$price_ranges = [10, 20, 30, 40, 50, 60, 70, 80, 90, 100];

for ($i = 0; $i < 100; $i++) {
    $product = [
        "name" => "T-Shirt #" . ($i + 1),
        "size" => $sizes[array_rand($sizes)],
        "color" => $colors[array_rand($colors)],
        "brand" => $brands[array_rand($brands)],
        "price" => $price_ranges[array_rand($price_ranges)],
    ];
    $products[] = $product;
}

// Λήψη φίλτρων από τη φόρμα
$sizeFilter = $_GET['size'] ?? '';
$colorFilter = $_GET['color'] ?? '';
$brandFilter = $_GET['brand'] ?? '';
$priceFilter = $_GET['price'] ?? '';

// Φιλτράρισμα προϊόντων
$filteredProducts = array_filter($products, function ($product) use ($sizeFilter, $colorFilter, $brandFilter, $priceFilter) {
    $match = true;

    if ($sizeFilter && $product['size'] !== $sizeFilter) {
        $match = false;
    }

    if ($colorFilter && $product['color'] !== $colorFilter) {
        $match = false;
    }

    if ($brandFilter && strtolower($product['brand']) !== $brandFilter) { // strtolower για σύγκριση πεζών-κεφαλαίων
        $match = false;
    }

    if ($priceFilter) {
        [$min, $max] = explode('-', $priceFilter);
        if ($product['price'] < $min || $product['price'] > $max) {
            $match = false;
        }
    }

    return $match;
});

// Εμφάνιση των προϊόντων που ταιριάζουν στα κριτήρια αναζήτησης
foreach ($filteredProducts as $product) {
    echo "<div class='product'>";
    echo "<h2>{$product['name']}</h2>";
    echo "<p>Μέγεθος: {$product['size']}</p>";
    echo "<p>Χρώμα: {$product['color']}</p>";
    echo "<p>Μάρκα: {$product['brand']}</p>";
    echo "<p>Τιμή: {$product['price']}€</p>";
    echo "</div>";
}
