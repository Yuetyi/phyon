<header class="header">
<script>
    function showmenu() {
      var menu = document.getElementById("menu");
      if (menu.style.display == "none" || menu.style.display == "") {
        menu.style.display = "block";
      } else {
        menu.style.display = "none";
      }
    }

    window.addEventListener('resize', function() {
      var width = window.innerWidth;
      var menu = document.getElementById("menu");
      if (width > 800) {
        menu.style.display = "block";
      } else {
        menu.style.display = "none";
      }
    });
  </script>
  <link rel="stylesheet" href="css/style.css">
  <div class="header">
  <div class="container">
    <div class="navbar">
      <div class="logo">
        <img src="images/logo.png" width="125px">
      </div>
      <nav>
        <ul id="menu">
          <li><a href="product.php">Products</a></li>
          <li><a href="myorder.php">Myorder</a></li>
          <li><a href="account.php">Account</a></li>
        </ul>
      </nav>
      <a href="cart.php"><img src="images/cart.png" width="30px" height="30px"></a><br>
      <img src="images/menu.png" class="menu-icon" onclick="showmenu()">
    </div>
  </div>
</header>
