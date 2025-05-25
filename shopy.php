<?php
$pdo = new PDO("mysql:host=localhost;dbname=db_image;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Search logic
if (!empty($search)) {
    $stmt = $pdo->prepare("SELECT * FROM tbl_image WHERE name LIKE ? ORDER BY id DESC");
    $stmt->execute(["%$search%"]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $products = $pdo->query("SELECT * FROM tbl_image ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
}

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    $stmt = $pdo->prepare("SELECT quantity FROM tbl_image WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        if ($product['quantity'] > 0) {
            $update = $pdo->prepare("UPDATE tbl_image SET quantity = quantity - 1 WHERE id = ?");
            $update->execute([$product_id]);

            echo "<script>
                alert('Successfully added to cart!');
                window.location.href='shopy.php';
            </script>";
            exit;
        } else {
            echo "<script>
                alert('Out of Stock');
                window.location.href='shopy.php';
            </script>";
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Tecno Shop</title>
<style>
    body {
  background-color: #121212;
  margin: 0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: #f1c40f;
font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
}
.header {
  background: linear-gradient(120deg, #1a1d23, #2c2c2c);
  padding: 10px 30px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 20px;
  box-sizing: border-box;
}

.header-left {
  display: flex;
  align-items: center;
  gap: 15px;
}

.header-left img {
  height: 60px;
  width: 60px;
  border-radius: 50%;
}

.header-left h1 {
  font-size: 28px;
  margin: 0;
}

.search-container {
  flex: 1;
  text-align: center;
}

.search-container form {
  display: inline-block;
}

.search-container input[type="search"] {
  padding: 10px;
  font-size: 16px;
  border-radius: 20px;
  border: 1px solid #f1c40f;
  background-color: #1e1e1e;
  color: #f1c40f;
  width: 500px;
  max-width: 100%;
  box-sizing: border-box;
}

.search-container button {
  padding: 10px 15px;
  background-color: #f1c40f;
  color: black;
  border: none;
  border-radius: 25%;
  cursor: pointer;
  margin-left: 5px;
  transition: background-color 0.3s ease;
}

.search-container button:hover {
  background-color: #d4ac0d;
}

.header-right {
  display: flex;
  align-items: center;
  justify-content: flex-end;
}

.open-modal {
  padding: 10px 15px;
  color: #f1c40f;
  border: 1px solid #f1c40f;
  background: transparent;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease, color 0.3s ease;
}

.open-modal:hover {
  background-color: #f1c40f;
  color: black;
}

.topnav {
  background-color: #1f1f1f;
  overflow: hidden;
}

.topnav a {
  float: left;
  display: block;
  color: #f1c40f;
  text-align: center;
  padding: 15px 20px;
  text-decoration: none;
  font-size: large;
  transition: background-color 0.3s ease, color 0.3s ease;
}

.topnav a:hover {
  background-color: #f1c40f;
  color: black;
}

.modal {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0%;
  top: 0%;
  width: 100%;
  height: 100vh;
  backdrop-filter: blur(5px);
  background-color: rgba(0, 0, 0, 0.6);
}

.modal-toggle {
  display: none;
}

.modal-toggle:checked + .modal {
  display: block;
}

.modal-content {
  background-color: #2c2c2c;
  color: #f1c40f;
  margin: 10% auto;
  height:450px;
  padding: 20px;
  border: 2px solid #f1c40f;
  width: 300px;
  border-radius: 10px;
  position: relative;
}

.close {
  float: right;
  font-size: 28px;
  font-weight: bold;
  color: #f1c40f;
  cursor: pointer;
}

.close:hover {
  color: #fff;
}
input[type="email"],
input[type="text"],
input[type="password"],
input[type="search"] {
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #f1c40f;
  background-color: #1e1e1e;
  color: #f1c40f;
  width: 100%;
  box-sizing: border-box;
}

button[type="log-in"],
button[type="Register"],
button[type="submit"] {
  background-color: #f1c40f;
  border: none;
  padding: 10px 20px;
  color: black;
  border-radius: 20%;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button[type="log-in"]:hover,
button[type="Register"]:hover,
button[type="submit"]:hover {
  background-color: #d4ac0d;
}

.product-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
  max-width: 1200px;
  margin: auto;
}

.product-card {
  background-color: #1e1e1e;
  border: 1px solid #f1c40f88;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 0 15px #f1c40f44;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  padding: 15px;
  text-align: center;
  color: #f1c40f;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 0 25px #f1c40fcc;
  border-color: #f1c40fcc;
}

.product-card img {
  max-width: 100%;
  height: 200px;
  object-fit: cover;
  border-radius: 8px;
  border: 2px solid #f1c40f;
  box-shadow: 0 0 10px #f1c40f66;
  background-color: #000;
}

.product-card h3 {
  margin: 10px 0 5px;
  font-size: 18px;
  color: #f1c40f;
}

.product-card p {
  margin: 5px 0;
  font-size: 15px;
  color: #ddd;
}

button[type="submit"] {
  background-color: transparent;
  border: 2px solid #f1c40f;
  color: #f1c40f;
  padding: 10px 16px;
  font-size: 14px;
  border-radius: 6px;
  cursor: pointer;
  margin-top: 10px;
  transition: background-color 0.3s ease, color 0.3s ease;
}

button[type="submit"]:hover {
  background-color: #f1c40f;
  color: #121212;
}

a {
  color: #f1c40f;
  text-decoration: none;
  transition: color 0.3s ease;
}

a:hover {
  color: #fff;
}

footer {
  background-color: #1a1d23;
  color: #ccc;
  padding: 20px;
  text-align: center;
  font-size: 14px;
  margin-top: 50px;
}

footer a {
  color: #f1c40f;
  text-decoration: none;
  margin: 0 10px;
}

h1 {
  text-align: center;
  font-weight: 700;
  font-size: 2.4rem;
  color: #f1c40f;
  margin-bottom: 30px;
  letter-spacing: 1.5px;
}

@media (max-width: 600px) {
  h1 {
    font-size: 24px;
  }

  .product-card img {
    height: 150px;
  }
}
html, body {
  margin: 0;
  padding: 0;
  height: 100%;
  overflow-y: scroll; /* enable scroll */
  scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none; /* IE 10+ */
}

html::-webkit-scrollbar, body::-webkit-scrollbar {
  display: none; /* Chrome, Safari, Opera */
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.fade-in {
  animation: fadeIn 1s ease-out both;
}

.fade-in-delayed {
  animation: fadeIn 1.2s ease-out both;
}

.modal-content {
  animation: fadeIn 0.5s ease-out both;
}

.modal {
    display: none;
    position: fixed;
    z-index: 999;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center; align-items: center;
  }

  #modal-toggle:checked ~ .modal {
    display: flex;
  }

  .modal-content {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    width: 350px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    position: relative;
  }

  .close {
    position: absolute;
    top: 10px; right: 15px;
    font-size: 24px;
    color: #000;
    cursor: pointer;
  }

  .tab-buttons {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 20px;
  }

  .tab-buttons button {
    padding: 10px 20px;
    background-color: #ddd;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  .tab-buttons button.active {
    background-color: #007BFF;
    color: white;
  }

  form input {
    width: 90%;
    padding: 8px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
  }

  form button {
    margin-top: 10px;
    padding: 10px 20px;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  form p {
    margin: 0;
    font-size: 12px;
    color: #333;
  }
.select-wrapper {
    position: relative;
    display: inline-block;
}

.dropdown {
    background-color: #1f1f1f;
    color: antiquewhite;
    
    font-size: large;
    padding: 15px 0px ;
    border: none;
    cursor: pointer;
    width: auto; /* Make the dropdown width based on content */
    text-align: center;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
    color: #f1c40f; 
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;" 
}



/* To make the options in the dropdown look better */
.dropdown option {
    background-color: #333333;
    color: antiquewhite;
    padding: 10px;
    font-size: large;
}

.dropdown option:hover {
    background-color: #555555;
}
</style>
</head>
<body>

<div class="header">
    <div class="header-left">
      <img src="logo.png" alt="TecnoZone Logo">
      <h1>Tecno Zone</h1>
    </div>
    <div class="search-container">
      <form method="get" action="shopy.php">
        <input type="search" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
      </form>
    </div>
    <div class="header-right">
      <label for="modal-toggle" class="open-modal">Login</label>
    </div>
</div>

<div class="topnav">
    <a href="index.php">HOME</a>
    <a href="item.php">PRODUCTS</a>
    <a href="about.php">ABOUT</a>
    <a href="shopy.php">SHOP NOW!</a>
    <div class="select-wrapper">
            <select class="dropdown" onchange="window.location.href=this.value;">
                <option selected>SERIES</option>
                <option value="spark.html">Tecno Spark</option>
                <option value="camon.html">Tecno Camon</option>
                <option value="pova.html">Tecno Pova</option>
            </select>
        </div>
    <input type="checkbox" id="modal-toggle" class="modal-toggle" hidden>
<div class="modal">
  <div class="modal-content">
    <label for="modal-toggle" class="close">&times;</label>

    <!-- Tab Buttons -->
    <div class="tab-buttons">
      <button id="login-tab" class="active" onclick="showForm('login')">Log In</button>
      <button id="register-tab" onclick="showForm('register')">Register</button>
    </div>

    <!-- Log-in Form -->
    <form id="login-form">
      <center>
        <h2>LOG-IN</h2>
        <input type="text" id="username" name="username" required>
        <p><label for="username">Username</label></p>
        <input type="password" id="password" name="password" required>
        <p><label for="password">Password</label></p>
        <button type="submit">Log In</button>
      </center>
    </form>

    <!-- Register Form -->
    <form id="register-form" style="display:none;">
      <center>
        <h2>REGISTER</h2>
        <input type="text" id="reg-username" name="reg-username" required>
        <p><label for="reg-username">Username</label></p>
        <input type="email" id="reg-email" name="reg-email" required>
        <p><label for="reg-email">Email</label></p>
        <input type="password" id="reg-password" name="reg-password" required>
        <p><label for="reg-password">Password</label></p>
        <input type="password" id="reg-confirm" name="reg-confirm" required>
        <p><label for="reg-confirm">Confirm Password</label></p>
        <button type="submit">Register</button>
      </center>
    </form>
  </div>
</div>

<script>
  function showForm(formType) {
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const loginTab = document.getElementById('login-tab');
    const registerTab = document.getElementById('register-tab');

    if (formType === 'login') {
      loginForm.style.display = 'block';
      registerForm.style.display = 'none';
      loginTab.classList.add('active');
      registerTab.classList.remove('active');
    } else {
      loginForm.style.display = 'none';
      registerForm.style.display = 'block';
      loginTab.classList.remove('active');
      registerTab.classList.add('active');
    }
  }
</script>
</div>

<div class="fade-in">
<center><h1> Shop Now!</h1></center>

<div class="product-grid">
    <?php if (empty($products)): ?>
        <p style="color: white; text-align: center;">No products found.</p>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <img src="uploads/<?php echo htmlspecialchars($product['filename']); ?>" alt="Product" />
                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                <p>₱<?php echo number_format($product['price'], 2); ?></p>
                <p>Available: <?php echo (int)$product['quantity']; ?></p>

                <form method="post">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>" />
                    <button type="submit">Add to Cart</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
        </div>
<footer>
  <p>&copy; <?php echo date("Y"); ?> Tecno Zone. All rights reserved.</p>
  <p><a href="index.php">Home</a> | <a href="about.php">About</a> | <a href="upload13.php">Admin</a></p>
</footer>
</body>
</html>  