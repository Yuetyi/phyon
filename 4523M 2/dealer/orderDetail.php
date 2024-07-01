<?php
session_start(); 

include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_order'])) {
    $orderID = $_POST['orderID'];
    $total = $_POST['total'];
    $sub = 0;
    require_once('conn.php');
    $conn = getDBconnection();

    $sql3 = "SELECT * FROM orders WHERE orderID = '$orderID'";
    $rs3 = mysqli_query($conn, $sql3);
    $rc3 = mysqli_fetch_assoc($rs3);

    $deliveryDate = new DateTime($rc3['deliveryDate']);
    $today = new DateTime();
    $interval = $deliveryDate->diff($today);
    $daysDiff = $interval->days;

    if ($daysDiff >= 2) {

        $updateStatusSql = "UPDATE orders SET orderStatus = 'Cancelled' WHERE orderID = '$orderID'";
        mysqli_query($conn, $updateStatusSql);

        $selectItemsSql = "SELECT * FROM ordersitem WHERE orderID = '$orderID'";
        $rs = mysqli_query($conn, $selectItemsSql);
        while ($rc = mysqli_fetch_assoc($rs)) {
            $sparePartNum = $rc['sparePartNum'];
            $orderQty = $rc['orderQty'];

            $updateStockSql = "UPDATE item SET stockItemQty = stockItemQty + $orderQty WHERE sparePartNum = '$sparePartNum'";
            mysqli_query($conn, $updateStockSql);
        }

        header('Location: myorder.php?cancelorder_success=1');
        exit();
    } else {
        
        header('Location: myorder.php?cancelorder_success=2');
        exit();
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Smart & Luxury Motor</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        fieldset {
            padding: 0;
            border: 1px solid #CCC;
            margin-bottom: 50px;
        }
        legend {
            margin-left: 1em;
            color: #ff523b;
            font-weight: bold;
        }
        label {
            float: left;
            width: 12em;
            margin-right: 1em;
        }
        fieldset ol {
            list-style: none;
            padding: 3px 2em;
            display: flex;
            flex-wrap: wrap;
        }
        fieldset li {
            line-height: 24px;
            margin: 5px 0;
            width: 50%;
        }
        fieldset li input.fildform {
            line-height: 24px;
            height: 24px;
            border: 1px solid #CCC;
            width: calc(100% - 12em - 1em);
        }
        fieldset li p {
            color: black;
            margin-left: 14em;  
        }
        fieldset .submit {
            border-style: none;
            margin-top: 10px;
            text-align: center;
            width: 100%;
        }
    </style>
    <script>
        function confirmCancel() {
            return confirm("Are you sure you want to cancel this order?");
        }
    </script>
</head>
<body>
    <div class="small-container cart">
        <table>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
            <?php
            if (isset($_SESSION['email'])) {
                $dealerID = $_SESSION['email'];
            } else {
                exit("Session email not set.");
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $orderID = $_POST['orderID'];
                $total = $_POST['total'];
                $sub = 0;
                require_once('conn.php');
                $conn = getDBconnection();
                $sql = "SELECT * FROM ordersitem INNER JOIN item ON ordersitem.sparePartNum = item.sparePartNum WHERE ordersitem.orderID = '$orderID'";
                $rs = mysqli_query($conn, $sql);
                while ($rc = mysqli_fetch_assoc($rs)) {
                    $sub += $rc['sparePartOrderPrice'];
                    echo '<tr>';
                    echo '<td>';
                    echo '<div class="cart-info">';
                    echo '<img src="images/' . $rc['sparePartImage'] . '">';
                    echo '<div>';
                    echo '<p>' . $rc['sparePartName'] .' - Id.'. $rc['sparePartNum'] .'</p>';
                    echo '<small>Price: $' . $rc['price'] . '</small>';
                    echo '</div>';
                    echo '</div>';
                    echo '</td>';
                    echo '<td style="text-align: center;">'. $rc['orderQty'] . '</td>';
                    echo '<td>$' . $rc['sparePartOrderPrice'] . '</td>';
                    echo '</tr>';
                }

                $sql3 = "SELECT * FROM orders WHERE orderID = '$orderID'";
                $rs3 = mysqli_query($conn, $sql3);
                $rc3 = mysqli_fetch_assoc($rs3);
                $sql4 = "SELECT * FROM salesmanager WHERE salesManagerID = '{$rc3['salesManagerID']}'";
                $rs4 = mysqli_query($conn, $sql4);
                $rc4 = mysqli_fetch_assoc($rs4);

                echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '" onsubmit="return confirmCancel()">
                          <fieldset>
                              <legend> Order Details</legend>
                              <ol>
                                  <li>
                                     <label for="orderID">Order ID:</label>
                                     <p>'.$rc3['orderID'].'</p>
                                     <input type="hidden" name="orderID" value="'.$rc3['orderID'].'">
                                  </li>
                                  <li>
                                     <label for="salesManagerID">Sales Manager ID:</label>
                                     <p>'.$rc3['salesManagerID'].'</p>
                                  </li>
                                  <li>
                                     <label for="contactName">Manager’s Name:</label>
                                     <p>'.$rc4['contactName'].'</p>
                                  </li>
                                  <li>
                                     <label for="contactNumber">Manager’s Number:</label>
                                     <p>'.$rc4['contactNumber'].'</p>
                                  </li>
                                  <li>
                                     <label for="orderDateTime">Order Date & Time:</label>
                                     <p>'.$rc3['orderDateTime'].'</p>
                                  </li>
                                  <li>
                                     <label for="deliveryDate">Delivery Date:</label>
                                     <p>'.$rc3['deliveryDate'].'</p>
                                  </li>
                                  <li>
                                     <label for="orderStatus">Order Status:</label>
                                     <p>'.$rc3['orderStatus'].'</p>
                                  </li>
                                  <li>
                                     <label for="deliveryAddress">Delivery Address:</label>
                                     <p>'.$rc3['deliveryAddress'].'</p>
                                  </li>
                                  <li>
                                     <input type="submit" class="button" name="cancel_order" value="Cancel Order">
                                  </li>
                              </ol>
                          </fieldset>
                          <div class="total-price">
                              <table>
                                  <tr><td>Subtotal</td><td>$'.$sub.'</td></tr>
                                  <tr><td>Shipping cost</td><td>$'.$rc3['shipCost'].'</td></tr>
                                  <tr><td>Total</td><td>$'.$total.'</td></tr>
                              </table>
                          </div>
                      </form>';
                mysqli_close($conn);
            }
            ?>
        </table>
    </div>
</body>
</html>