<?php
session_start();

if (isset($_POST['email'])) {
    // Store the user ID and password in session variables
    $_SESSION['email'] = $_POST['email'];

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Missing user ID or password']);
}
?>