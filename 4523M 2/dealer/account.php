<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Cart - Smart & Luxury Motor</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
     .box {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 30rem;
    padding: 3.5rem;
    box-sizing: border-box;
    border: 1px solid #dadce0;
    -webkit-border-radius: 8px;
    border-radius: 8px;
     
}
 
.box p {
    font-size: 16px;
    font-weight: 400;
    letter-spacing: 1px;
    line-height: 1.5;
    margin-bottom: 24px;
    text-align: center;
}
 
.box .inputBox {
    position: relative;
}
 
.box .inputBox input {
    width: 100%;
    padding: 1rem 10px;
    font-size: 1rem;
   letter-spacing: 0.062rem;
   margin-bottom: 1.875rem;
   border: 1px solid #ccc;
   border-radius: 4px;
}
 
.box .inputBox label {
    position: absolute;
    top: 0;
    left: 10px;
    padding: 0.625rem 0;
    font-size: 1rem;
    color: gray;
    pointer-events: none;
    transition: 0.5s;
}
 
.box .inputBox input:focus ~ label,
.box .inputBox input:valid ~ label,
.box .inputBox input:not([value=""]) ~ label {
    top: -1.8rem;
    left: 5px;
    color: gray;
    font-size: 0.75rem;
    background-color: #fff;
    height: 10px;
    padding-left: 5px;
    padding-right: 5px;
}
 
.box .inputBox input:focus {
    outline: none;
    border: 2px solid #ff523b;
}
</style>
</head>
<body>
  
  <div class="box">
    <p>Account Settings</p>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <div class="inputBox">
        <input type="text" name="password">
        <label>Password</label>
      </div>
      <div class="inputBox">
        <input type="text" name="contact">
        <label>Contact Number</label>
      </div>
      <div class="inputBox">
        <input type="text" name="fax">
        <label>Fax Number</label>
      </div>
      <div class="inputBox">
        <input type="text" name="address">
        <label>Delivery Address</label>
      </div>
      <input type="submit" style="margin: auto; display:block" name="Edit" class="button" value="Edit">
    </form>
    <a href="..\logout.php"><img style="float: right; " src="images/logout.png" width="25px" height="25px"></a>
  </div>

  <?php
  session_start();
  if (isset($_SESSION['email'])) {
    $dealerID = $_SESSION['email'];
  } else {
    exit("Session email not set.");
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('conn.php'); 
    $conn = getDBconnection();

    if (!empty($_POST["password"])) {
      $password = mysqli_real_escape_string($conn, $_POST["password"]);
      $sql = "UPDATE dealer SET password = '$password' WHERE dealerID = '$dealerID'";
      if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Password updated successfully');</script>";
      } else {
        echo "<script>alert('Error updating password: " . mysqli_error($conn) . "');</script>";
      }
    }

    if (!empty($_POST["contact"])) {
      $contact = mysqli_real_escape_string($conn, $_POST["contact"]);
      $sql = "UPDATE dealer SET contactNumber = '$contact' WHERE dealerID = '$dealerID'";
      if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Contact number updated successfully');</script>";
      } else {
        echo "<script>alert('Error updating contact number: " . mysqli_error($conn) . "');</script>";
      }
    }

    if (!empty($_POST["fax"])) {
      $fax = mysqli_real_escape_string($conn, $_POST["fax"]);
      $sql = "UPDATE dealer SET faxNumber = '$fax' WHERE dealerID = '$dealerID'";
      if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Fax number updated successfully');</script>";
      } else {
        echo "<script>alert('Error updating fax number: " . mysqli_error($conn) . "');</script>";
      }
    }

    if (!empty($_POST["address"])) {
      $address = mysqli_real_escape_string($conn, $_POST["address"]);
      $sql = "UPDATE dealer SET deliveryAddress = '$address' WHERE dealerID = '$dealerID'";
      if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Delivery address updated successfully');</script>";
      } else {
        echo "<script>alert('Error updating delivery address: " . mysqli_error($conn) . "');</script>";
      }
    }

    mysqli_close($conn);
  }
  ?>
</body>
</html>