<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>All Products - Smart & Luxury Motor</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="jquery/jquery-2.1.4.js"></script>
  <script>
    $(document).ready(function() {
      function loadProducts(sortValue) {
        $.ajax({
          type: 'POST',
          url: 'sort_products.php',
          data: { sort: sortValue },
          success: function(response) {
            $('#product-list').html(response);
          },
          error: function(xhr, status, error) {
            console.error('Error loading products:', error);
            $('#product-list').html('<p>Failed to load products. Please try again later.</p>');
          }
        });
      }
      loadProducts('def');
      $('#sort').change(function() {
        var sortValue = $(this).val();
        loadProducts(sortValue);
      });
    });

    function addToCart(sparePartNum) {
    $.ajax({
      type: 'POST',
      url: 'cart.php',
      data: { action: 'add', sparePartNum: sparePartNum },
      success: function(response) {
        alert('Item added to cart successfully.');
      },
    });
  }
  </script>
</head>

<body>
  

  <div class="small-container">
    <div class="row row-2">
      <h2>All Products</h2>
      <select name="sort" id="sort">
        <option value="def">Default Sorting</option>
        <option value="price_asc">Sort by Price: Low to High</option>
        <option value="price_desc">Sort by Price: High to Low</option>
        <option value="name_asc">Sort by Name: A-Z</option>
        <option value="name_desc">Sort by Name: Z-A</option>
      </select>
    </div>
    <div id="product-list" class="row">
      <!-- Product list will be populated dynamically -->
    </div>
  </div>

</body>

</html>
