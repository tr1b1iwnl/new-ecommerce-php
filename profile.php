<?php
session_start();

if (!isset($_SESSION['auth']) || !$_SESSION['auth']) {
  header("Location: login.php");
  exit();
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Profile</title>
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="./assets/css/header.css">
  <link rel="stylesheet" href="./assets/css/footer.css">
  <link rel="stylesheet" href="./assets/css/profile.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="./assets/js/profile-menu.js"></script>
</head>

<body>
  <header>
    <img src="./assets/img/logo.png" class="logo" alt="RILL" width="150">
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="#">Clothing</a></li>
        <li><a href="#">Gadgets</a></li>
        <li><a href="#">Sports</a></li>
        <li><a href="about_me.php">About Me</a></li>
      </ul>
    </nav>
    <div class="searchbox">
      <svg viewBox="0 0 24 24" role="img" width="30px" height="30px" fill="none">
        <path stroke="#201c1c" stroke-width="1.5"
          d="M13.962 16.296a6.716 6.716 0 01-3.462.954 6.728 6.728 0 01-4.773-1.977A6.728 6.728 0 013.75 10.5c0-1.864.755-3.551 1.977-4.773A6.728 6.728 0 0110.5 3.75c1.864 0 3.551.755 4.773 1.977A6.728 6.728 0 0117.25 10.5a6.726 6.726 0 01-.921 3.407c-.517.882-.434 1.988.289 2.711l3.853 3.853">
        </path>
      </svg>
      <input type="text" id="search" class="pre-search-input input-text" name="search" placeholder="Search"></input>
      <div class="profile-container">
        <div class="profile-circle" onclick="toggleMenu()">
          <img src="./assets/img/profile-pic.png" alt="profile pic">
        </div>
        <div id="profile-menu" class="hidden">
          <ul>
            <li onclick="window.location.href = 'profile.php';">Profile</li>
            <hr>
            <li onclick="signOut()">Sign Out</li>
          </ul>
        </div>
      </div>
    </div>
  </header>
  <main class="profile">
    <div class="profile-pic">
      <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
        alt="Profile Picture" />
    </div>
    <div class="form-container">
      <?php
      if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
      }

      if (isset($_SESSION['error'])) {
        echo "<p class='error-message'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
      }

      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "dbecommerce";

      $conn = mysqli_connect($servername, $username, $password, $dbname);

      $sql = "SELECT firstname, lastname, username, password FROM tbluseraccount WHERE username = ?";
      $stmt = $conn->prepare($sql);
      $username = $_SESSION['username'];
      $stmt->bind_param("s", $username);
      $stmt->execute();
      $result = $stmt->get_result();
      $user = $result->fetch_assoc();

      if ($user) {
        echo '<h1>' . $user['firstname'] . ' ' . $user['lastname'] . '</h1>';
        echo '<form method="POST" action="auth.php">';
        echo '<input type="text" name="firstname" value="' . $user['firstname'] . '" placeholder="First Name" required>';
        echo '<input type="text" name="lastname" value="' . $user['lastname'] . '" placeholder="Last Name" required>';
        echo '<input type="text" name="username" value="' . $user['username'] . '" placeholder="Username" required>';
        echo '<input type="password" name="password" placeholder="Password" required>';
        echo '<button type="submit" name="update" class="edit-button">Save Changes</button>';
        echo '</form>';
      } else {
        echo 'User not found.';
      }
      ?>
    </div>
  </main>
  <footer class="footer-black">
    <div class="footer-fashion">
      <img src="./assets/img/dashboard_foot.png" alt="fashion" width="400">
    </div>
    <div class="footer-nav">
      <ul>
        <li>ABOUT US</li>
        <li>Find a Store</li>
        <li>Order Status</li>
        <li>Delivery</li>
        <li>Get Help</li>
      </ul>
    </div>
    <div class="footer-nav">
      <ul>
        <li>CLOTHING</li>
        <li>Men's Apparel</li>
        <li>Women's Apparel</li>
        <li>Kids' Apparel</li>
        <li>Sale</li>
      </ul>
    </div>
    <div class="footer-nav">
      <ul>
        <li>GADGETS</li>
        <li>Laptops</li>
        <li>Computers</li>
        <li>Mobile Phones</li>
        <li>Accessories</li>
      </ul>
    </div>
    <div class="footer-nav">
      <ul>
        <li>SPORTS</li>
        <li>Sport Clothes</li>
        <li>Shoes</li>
        <li>Sport Gears</li>
        <li>Accessories</li>
      </ul>
    </div>
    <div class="footer-nav">
      <ul>
        <li>FOLLOW US</li>
        <li><a href="#" class="fa fa-facebook"></a></li>
        <li><a href="#" class="fa fa-twitter"></a></li>
        <li><a href="#" class="fa fa-instagram"></a></li>
      </ul>
    </div>
    <p class="copyright">&copy; RILL Philippines 2023</p>
  </footer>
</body>

</html>