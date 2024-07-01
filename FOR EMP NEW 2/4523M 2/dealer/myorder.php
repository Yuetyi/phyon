<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Smart & Luxury Motor</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>


        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #ff523b;
        }
        th:last-child {
            text-align: center;
        }   
        tr:nth-child(even) {
             background-color: #f2f2f2;
        } 
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .view-button, .ship-button {
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .view-button {
            background-color: #4CAF50;
            color: white;
        }
        .ship-button {
            background-color: #008CBA;
            color: white;
        }
    </style>

<?php
    if (isset($_GET['cancelorder_success']) && $_GET['cancelorder_success'] == 1) {
        echo "<script>alert('Cancel Order Successfully!');</script>";
      }else if(isset($_GET['cancelorder_success']) && $_GET['cancelorder_success'] == 2){
        echo '<script>alert("Cannot cancel order. Delivery date is less than two days away.")</script>';
      }
?>
</head>
<body>
<div class="small-container cart">
<div class="container">
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Purchased on</th>
                <th>Delivery Address</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
<?php
  session_start();
  if (isset($_SESSION['email'])) {
    $dealerID = $_SESSION['email'];
  } else {
    exit("Session email not set.");
  }
  require_once('conn.php');
  $conn = getDBconnection();
  $sql = "SELECT * FROM orders WHERE dealerID = '$dealerID' ORDER BY orderID DESC";
  $rs = mysqli_query($conn, $sql);
  while($rc = mysqli_fetch_assoc($rs)){
    $sql1 = "SELECT SUM(sparePartOrderPrice) AS SUM FROM ordersitem WHERE orderID = '$rc[orderID]'";
    $rs1 = mysqli_query($conn, $sql1);
    $rc1 = mysqli_fetch_assoc($rs1);
    $total = $rc['shipCost'] + $rc1['SUM'];
    echo "<tr>
                <td>".$rc['orderID']."</td>
                <td>".$rc['orderDateTime']."</td>
                <td>".$rc['deliveryAddress']."</td>
                <td>".$total."</td>
                <td>".$rc['orderStatus']."</td>
                <td>
                    <form action='orderdetail.php' method='post'>
                        <input type='hidden' name='orderID' value='".$rc['orderID']."'>
                        <input type='hidden' name='total' value='".$total."'>
                        ";if($rc['orderStatus'] != 'Cancelled'){
                            echo "<button type='submit' class='view-button' name='detail'>View</button>";
                        }
             echo "</form>
                </td>
            </tr>";
    } 
    mysqli_close($conn);
?>
        </tbody>
    </table>
</div>
</div>
</body>
</html>

