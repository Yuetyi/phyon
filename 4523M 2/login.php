<?php
$hostname = "127.0.0.1";
$database = "projectDB";
$username = "root";
$password = "";
$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: ". mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $query = "SELECT * FROM Dealer WHERE dealerID = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        echo 'dealer';
        exit;
    }
    
    $query = "SELECT * FROM SalesManager WHERE salesManagerID = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        echo 'salesmanager';
        exit;
    }
    
    echo 'error';
}
?>