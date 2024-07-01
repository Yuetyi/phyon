<?php
session_start();
require_once('conn.php');
$conn = getDBconnection();

if (isset($_POST['sort'])) {
    $sort = $_POST['sort'];
    switch ($sort) {
        case 'price_asc':
            $sql = "SELECT * FROM Item WHERE stockItemQty > 0 ORDER BY price ASC";
            break;
        case 'price_desc':
            $sql = "SELECT * FROM Item WHERE stockItemQty > 0 ORDER BY price DESC";
            break;
        case 'name_asc':
            $sql = "SELECT * FROM Item WHERE stockItemQty > 0 ORDER BY sparePartName ASC";
            break;
        case 'name_desc':
            $sql = "SELECT * FROM Item WHERE stockItemQty > 0 ORDER BY sparePartName DESC";
            break;
        default:
            $sql = "SELECT * FROM Item WHERE stockItemQty > 0 ORDER BY sparePartNum";
            break;
    }

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col">
                <img src="images/' . $row['sparePartImage'] . '">
                 <h5>' . getCategoryName($row['sparePartCategory']) . '</h5>
                 <h4>' . $row['sparePartName'] . '</h4>
                 <div class="box">
                 <p> $ ' . $row['price'] . '</p>
                 <button onclick="addToCart(' . $row['sparePartNum'] . ')">Add To Cart</button>
                 </div>
                 </div>';
            }
        } else {
            echo 'No products found.';
        }

        $stmt->close();
    } else {
        echo 'Error preparing statement: ' . $conn->error;
    }

    $conn->close();
} else {
    echo 'Invalid request.';
}

function getCategoryName($categoryId) {
    return "Category Name"; 
}
?>
