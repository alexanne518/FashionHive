<?php
include "src/ClassCloset.php";

// Get search filters
$category = $_POST['category'] ?? '0';
$color = $_POST['color'] ?? '0';
$size = $_POST['size'] ?? '0';
$sort = $_POST['sort'] ?? '0';

// Fetch matching clothes from database
$results = Closet::ReadClosetItems($category, $color, $size, $sort);

// Display results
if (empty($results)) {
    echo "<p>No items found.</p>";
} else {
    foreach ($results as $item) {
        echo "<div class='item'>";
        echo "<h3>{$item['name']}</h3>";
        echo "<p>Color: {$item['color']}, Size: {$item['size']}</p>";
        echo "</div>";
    }
}
?>