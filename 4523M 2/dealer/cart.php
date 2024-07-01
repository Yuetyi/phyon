<?php include 'header.php'; ?>
<?php
session_start();

if (isset($_POST['action']) && $_POST['action'] == 'add' && isset($_POST['sparePartNum'])) {
    $sparePartNum = $_POST['sparePartNum'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (isset($_SESSION['cart'][$sparePartNum])) {
        $_SESSION['cart'][$sparePartNum]++;
    } else {
        $_SESSION['cart'][$sparePartNum] = 1;
    }

}

require_once('conn.php');
$conn = getDBconnection();

if (isset($_GET['order_success']) && $_GET['order_success'] == 1) {
  echo "<script>alert('Successfully ordered!');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shopping Cart - Smart & Luxury Motor</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="jquery/jquery-2.1.4.js"></script>
  <script>
  $(document).ready(function() {

    $('input[type="number"]').on('change', function() {
      var sparePartNum = $(this).closest('tr').data('sparepartnum');
      var newQuantity = $(this).val();

      updateQuantityAndSubmitForm(sparePartNum, newQuantity);
    });

    $('.remove-link').on('click', function(e) {
      e.preventDefault();
      var sparePartNum = $(this).data('sparepartnum');
      updateQuantityAndSubmitForm(sparePartNum, 0); 
    });

    function updateQuantityAndSubmitForm(sparePartNum, quantity) {
      var formData = new FormData();
      formData.append('sparePartNum', sparePartNum);
      formData.append('quantity', quantity);

      $.ajax({
        type: 'POST',
        url: 'update_cart.php',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          console.log('Cart updated successfully');
          location.reload();
        },
        error: function(xhr, status, error) {
          console.error('Error updating cart:', error);
          alert('Failed to update cart. Please try again later.');
        }
      });
    }
  });
  
  </script>
</head>
<body>
  

  <div class="small-container cart">
    <table>
    <tr>
      <th style="width:60%;">Product</th>
      <th >Quantity</th>
      <th style="width:33%;">Subtotal</th>
    </tr>

    <?php
    $Price = 0;
    $tquantity = 0;
    $tweight = 0;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $sparePartNum => $quantity) {
            
            $sql = "SELECT * FROM Item WHERE sparePartNum = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $sparePartNum);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $subtotal = $row['price'] * $quantity;
                    $tquantity += $quantity;
                    $tweight += $quantity * $row['weight'];
                    $Price += $subtotal;
                    echo '<tr data-sparepartnum="' . $sparePartNum . '">';
                    echo '<td>';
                    echo '<div class="cart-info">';
                    echo '<img src="images/' . $row['sparePartImage'] . '">';
                    echo '<div>';
                    echo '<p>' . $row['sparePartName'] .' - Id.'. $row['sparePartNum'] .'</p>';
                    echo '<small>Price: $' . $row['price'] . '</small>';
                    echo '<br>';
                    echo '<a href="#" class="remove-link" data-sparepartnum="' . $sparePartNum . '">Remove</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</td>';
                    echo '<td style="text-align: right;"><input type="number" value="' . $quantity . '" min="1"></td>';
                    echo '<td>$' . $subtotal . '</td>';
                    echo '</tr>';
                }
            }


        }
        echo '</table>';
        echo '<div class="total-price">
        <form method="post" action="place_order.php">
        <input type="hidden" id="shippingcostInput" name="shippingcost" value="">
        <fieldset>
          <legend> Order Details</legend>
            <ol>
            <li>
             <label for="shipdate">Delivery Date:</label>
             <input id="shipdate" name="shipdate" type="date" class="fildform" />
            </li>
            <li>
             <label for="ship">Shipping way:</label>
              <select name="ship" id="ship">
              <option value="quantity">Quantity</option>
              <option value="weight">Weight</option>
              </select>
            </li>
            <li>
            <input type="submit" class="button" name="submit_order" value="Order">
            </li>
            </ol>
          </fieldset>
          
          
        </form>

        <table><tr><td>Subtotal</td><td>$'.$Price.'</td></tr><tr><td>Shipping cost</td><td id="shippingcost"></td></tr><tr><td>Total</td><td id="totalPrice"></td></tr></table>
        </div>';
    } else {
        echo '<tr style="background-color: #f2f2f2;"><td><p>No items in cart. </p></td><td></td><td></td></tr>';
        echo '</table>';
    }

    $conn->close();
    ?>
  </table>
  </div>
  <script>
    var tquantity = <?php echo $tquantity ?>;
    var tweight = <?php echo $tweight ?>;
    var Price = <?php echo $Price ?>;
    $(document).ready(function() {
      
      function checkship(shipType) {
        var numValue = shipType === 'quantity' ? tquantity : tweight;
        $.ajax({
          url: 'callPythonRESTful.php',
          type: 'POST',
          data: { ship: shipType, num: numValue },
          success: function(response) {
            var responseData = JSON.parse(response);
            if (responseData.result === 'rejected') {
              alert('Shipping calculation rejected: ' + responseData.reason);
            } else if (responseData.result === 'accepted') {
              var newCost = parseInt(responseData.cost);
              var totalPrice = Price + newCost;
              $('#shippingcost').text('$' + newCost);
              $('#totalPrice').text('$' + totalPrice);
              $('#shippingcostInput').val(newCost);
            }
          },
        });
      }
      checkship('quantity');
      $('#ship').change(function() {
        var shipType = $(this).val();
        checkship(shipType);
      });

    });
  </script>
  
</body>
</html>
