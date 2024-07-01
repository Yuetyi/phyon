<?php
session_start();

if (!isset($_POST['shipdate']) || empty($_POST['shipdate']) || $_POST['shipdate'] === '0') {
    echo '<script>alert("Please enter a valid ship date.");';
    echo 'window.location.href = "cart.php";</script>';
    exit;
}

if (!isset($_POST['shippingcost']) || empty($_POST['shippingcost']) || $_POST['shippingcost'] === '0') {
    echo '<script>alert("Please enter valid shipping cost.");';
    echo 'window.location.href = "cart.php";</script>';
    exit;
}

$today = date("Y-m-d");
$shipdate = $_POST['shipdate'];

if ($shipdate < $today) {
    echo '<script>alert("Ship date cannot be earlier than today.");';
    echo 'window.location.href = "cart.php";</script>';
    exit;
}

if (isset($_SESSION['email'])) {
    $dealerID = $_SESSION['email'];
} else {
    exit("Session email not set.");
}

require_once('conn.php'); 
$conn = getDBconnection(); 
if (isset($_POST['submit_order'])) {

    mysqli_autocommit($conn, false);

    try {

        $sql1 = "SELECT deliveryAddress FROM dealer WHERE dealerID = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("s", $dealerID);
        $stmt1->execute();
        $rs1 = $stmt1->get_result();
        $deliveryAddress = $rs1->fetch_assoc()['deliveryAddress'];
        $rs1->close();

        $sql2 = "SELECT MAX(orderID) as maxOrderID FROM Orders";
        $rs2 = mysqli_query($conn, $sql2);
        $maxOrderID = mysqli_fetch_assoc($rs2)['maxOrderID'] + 1;
        mysqli_free_result($rs2);

        $sql3 = "SELECT salesmanagerID FROM salesmanager ORDER BY RAND() LIMIT 1";
        $rs3 = mysqli_query($conn, $sql3);
        $salesID = mysqli_fetch_assoc($rs3)['salesmanagerID'];
        mysqli_free_result($rs3);

        $now = date("Y-m-d H:i:s");
        $shippingcost = $_POST['shippingcost'];
        $sql = "INSERT INTO Orders (orderID, dealerID, salesManagerID, orderDateTime, deliveryAddress, deliveryDate, orderStatus, shipCost) 
                VALUES (?, ?, ?, ?, ?, ?, 'Processing', ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssss", $maxOrderID, $dealerID, $salesID, $now, $deliveryAddress, $shipdate, $shippingcost);
        $stmt->execute();

        foreach ($_SESSION['cart'] as $sparePartNum => $quantity) {
            $sql = "SELECT * FROM Item WHERE sparePartNum = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $sparePartNum);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $tprice = $quantity * $row['price'];
                    $sql = "INSERT INTO Ordersitem (orderID, sparePartNum, orderQty, sparePartOrderPrice) 
                            VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("iiid", $maxOrderID, $sparePartNum, $quantity, $tprice);
                    $stmt->execute();

                    $sql = "UPDATE Item SET stockItemQty = stockItemQty - ? WHERE sparePartNum = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $quantity, $sparePartNum);
                    $stmt->execute();
                }
            }
        }

        mysqli_commit($conn);

        unset($_SESSION['cart']);

        header("Location: CART.php?order_success=1");
        exit;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "Error: " . $e->getMessage();
    }

    mysqli_close($conn);
}
?>