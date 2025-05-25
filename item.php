<?php
$pdo = new PDO("mysql:host=localhost;dbname=db_image;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if (!empty($search)) {
    $stmt = $pdo->prepare("SELECT * FROM tbl_image WHERE name LIKE ? ORDER BY id DESC");
    $stmt->execute(["%$search%"]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $products = $pdo->query("SELECT * FROM tbl_image ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecno Products</title>
    <meta name="description" content="Browse stylish and affordable shoes from Bagyo Shoes. View product details, prices, and more.">
    <meta name="keywords" content="Bagyo Shoes, affordable shoes, sneaker deals, stylish footwear">
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
  padding: 20px;
  border: 2px solid #f1c40f;
  width: 300px;
  height: 450px;
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

        
        .gallery {
            margin: 50px auto 30px;
            perspective: 1200px;
            display: flex;
            justify-content: center;
        }

        .gallery-container {
            width: 320px;
            height: 320px;
            position: relative;
            transform-style: preserve-3d;
            animation: rotate 15s infinite linear;
            border-radius: 15px;
        }

        .gallery-image {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 15px;
            overflow: hidden;
        }

        .gallery-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .gallery-image:nth-child(1) { transform: rotateY(0deg); }
        .gallery-image:nth-child(2) { transform: rotateY(90deg); }
        .gallery-image:nth-child(3) { transform: rotateY(180deg); }
        .gallery-image:nth-child(4) { transform: rotateY(270deg); }

        @keyframes rotate {
            0% { transform: rotateY(0deg); }
            100% { transform: rotateY(360deg); }
        }

        h1 {
            text-align: center;
            font-weight: 700;
            font-size: 2.4rem;
            color: #f1c40f;
            margin-bottom: 30px;
            letter-spacing: 1.5px;
        }

        .product-gallery {
            max-width: 1100px;
            margin: 0 auto 50px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 30px;
            padding: 0 20px;
        }

        .product {
  max-width: 250px;
  width: 100%;
  background-color: #222;
  border-radius: 12px;
  overflow: hidden;
  text-align: center;
  box-shadow: 0 5px 15px rgba(241, 196, 15, 0.2);
  border: 1px solid #444;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
  text-decoration: none;
  color: inherit;
}

        .product:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(241, 196, 15, 0.5);
        }
.product-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 15px;
}
        .product img {
             max-width: 100%;
  height: auto;
  display: block;
  margin: 0 auto;
            object-fit: cover;
            border-bottom: 2px solid #f1c40f;
            border-radius: 0 0 12px 12px;
        }

        .product-info h3 {
            margin: 15px 0 8px;
            font-weight: 600;
            font-size: 1.2rem;
            color: #eee;
        }

        .product-info .price {
            font-size: 1.3rem;
            color: #f1c40f;
            font-weight: 700;
        }

        nav.nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #1a1a1a;
        }

        .logo {
            color: #f1c40f;
            font-size: 1.5rem;
            font-weight: bold;
        }

        nav {
        position: fixed;
        top: 0; left: 0; right: 0;
        height: 60px;
        background-color: #1e1e1e;
        border-bottom: 2px solid #f1c40f;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 20px;
        z-index: 1000;
        box-shadow: 0 0 15px #f1c40f44;
    }

    nav .logo {
        font-weight: 700;
        font-size: 22px;
        color: #f1c40f;
        text-shadow: 0 0 8px #f1c40f88;
        user-select: none;
    }

    nav form {
        flex-grow: 1;
        margin: 0 20px;
    }

    nav form input[type="text"] {
        width: 100%;
        padding: 8px 12px;
        border-radius: 20px;
        border: 2px solid #f1c40f;
        background-color: #121212;
        color: #f1c40f;
        font-size: 16px;
        outline: none;
        transition: background-color 0.3s ease;
    }

    nav form input[type="text"]::placeholder {
        color: #f1c40faa;
    }

    nav form input[type="text"]:focus {
        background-color: #1e1e1e;
    }

    nav button {
        display: none; /* hidden because form submits on enter */
    }

    nav .nav-links a {
        color: #f1c40f;
        text-decoration: none;
        font-weight: 600;
        margin-left: 20px;
        border: 2px solid transparent;
        padding: 6px 14px;
        border-radius: 6px;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    nav .nav-links a:hover {
        background-color: #f1c40f;
        color: #121212;
        border-color: #f1c40f;
    }


        @media (max-width: 600px) {
            h1 {
                font-size: 24px;
            }

            .gallery-container {
                width: 260px;
                height: 260px;
            }

            nav {
                flex-wrap: wrap;
                height: auto;
                gap: 10px;
            }

            nav form {
                flex-basis: 100%;
                justify-content: center;
            }

            .product img {
                height: 70%;
            }

            .nav {
                flex-wrap: wrap;
                gap: 10px;
            }}
            body::-webkit-scrollbar {
      display: none;
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
    /* Smooth fade-in animation for product cards */
.product {
  opacity: 0;
  transform: translateY(20px);
  animation: fadeIn 0.5s ease forwards;
}

.product:nth-child(1) { animation-delay: 0.1s; }
.product:nth-child(2) { animation-delay: 0.2s; }
.product:nth-child(3) { animation-delay: 0.3s; }
/* Add more nth-child if you have more products */

@keyframes fadeIn {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Subtle card zoom effect */
.product:hover {
  transform: scale(1.05);
}

/* Stylish glow effect on hover */
.product:hover {
  box-shadow: 0 0 25px rgba(241, 196, 15, 0.6);
}

/* Scrollbar styling for better aesthetics */
body::-webkit-scrollbar {
  width: 8px;
}

body::-webkit-scrollbar-track {
  background: #1e1e1e;
}

body::-webkit-scrollbar-thumb {
  background-color: #f1c40f;
  border-radius: 10px;
}

/* More prominent 'No products found' styling */
.product-gallery p {
  font-size: 20px;
  color: #f1c40f;
  margin-top: 50px;
  grid-column: 1 / -1;
}

/* Enhance footer */
footer {
  border-top: 1px solid #444;
  box-shadow: 0 -2px 10px rgba(241, 196, 15, 0.1);
}

footer a:hover {
  color: #fff;
  text-decoration: underline;
}

/* Modal improvement - center on mobile */
@media (max-width: 600px) {
  .modal-content {
    margin: 30% auto;
    width: 90%;
  }
}

/* Add transition for all buttons */
button,
.open-modal {
  transition: all 0.3s ease;
}

/* Additional hover effect for login button */
.open-modal:hover {
  box-shadow: 0 0 10px #f1c40f;
}

input[type="email"]:focus,
input[type="text"]:focus,
input[type="password"]:focus,
input[type="search"]:focus {
  border-color: #ffd700;
  box-shadow: 0 0 8px rgba(241, 196, 15, 0.5);
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
      <form method="get" action="item.php">
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


<div class="gallery">
    <div class="gallery-container">
        <div class="gallery-image"><img src="1.png" alt="Gallery 1"></div>
        <div class="gallery-image"><img src="2.png" alt="Gallery 2"></div>
        <div class="gallery-image"><img src="3.png" alt="Gallery 3"></div>
        <div class="gallery-image"><img src="4.png" alt="Gallery 4"></div>
    </div>
</div>
<div class="product-container">
<div class="product-gallery">
    <?php foreach ($products as $product): ?>
        <a href="details.php?id=<?php echo $product['id']; ?>" class="product">
            <img loading="lazy" src="uploads/<?php echo htmlspecialchars($product['filename']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            <div class="product-info">
                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                <div class="price">₱<?php echo number_format($product['price'], 2); ?></div>
            </div>
        </a>
    <?php endforeach; ?>

    <?php if (empty($products)): ?>
        <p style="text-align: center;">No products found.</p>
    <?php endif; ?>
</div></div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search');
    const searchBtn = document.getElementById('searchBtn');
    const products = document.querySelectorAll('.product');

    function filterProducts() {
        const query = searchInput.value.toLowerCase().trim();
        products.forEach(product => {
            const name = product.querySelector('.product-info h3').textContent.toLowerCase();
            product.style.display = name.includes(query) || query === '' ? '' : 'none';
        });
    }

    searchBtn.addEventListener('click', filterProducts);
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            filterProducts();
        }
    });
});
</script>
<footer>
  <p>&copy; <?php echo date("Y"); ?> Tecno Zone. All rights reserved.</p>
  <p><a href="index.php">Home</a> | <a href="about.html">About</a> | <a href="upload13.php">Admin</a></p>
</footer>
</body>
</html>