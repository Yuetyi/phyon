<?php
session_start();

if (isset($_POST['sparePartNum']) && isset($_POST['quantity'])) {
    $sparePartNum = $_POST['sparePartNum'];
    $newQuantity = $_POST['quantity'];


    if ($newQuantity > 0) {
        $_SESSION['cart'][$sparePartNum] = intval($newQuantity);
    } else {
        unset($_SESSION['cart'][$sparePartNum]);
    }
    echo 'Cart updated successfully.';
} else {
    echo 'Invalid request.';
}
?>