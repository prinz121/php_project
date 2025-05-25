<?php
$pdo = new PDO("mysql:host=localhost;dbname=db_image;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "Product not found.";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM tbl_image WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "Product not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #2b2b2b;
            color: #f4f4f4;
        }

        .product-detail {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: #1a1d23;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            text-align: center;
            animation: fadeIn 0.6s ease-in-out;
        }

        .product-detail img {
            max-width: 200px;
            width: 100%;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .product-detail h2 {
            color: #ffd700;
            margin: 10px 0;
            font-size: 1.5rem;
        }

        .product-detail h3 {
            color: #f1c40f;
            font-size: 1.2rem;
            margin: 5px 0 10px;
        }

        .product-detail p {
            color: #ccc;
            font-size: 0.95rem;
            line-height: 1.4;
        }

        .back-button {
            margin-top: 20px;
            display: inline-block;
            background-color: #ffd700;
            color: #2b2b2b;
            padding: 8px 18px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 0 6px #ffd700;
            transition: 0.3s ease;
        }

        .back-button:hover {
            background-color: #333;
            color: #ffd700;
            box-shadow: 0 0 8px #fff176;
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

        @media (max-width: 500px) {
            .product-detail {
                margin: 20px 10px;
                padding: 15px;
            }
            .product-detail h2 {
                font-size: 1.2rem;
            }
            .product-detail h3 {
                font-size: 1rem;
            }
            .product-detail p {
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>

<div class="product-detail">
    <img src="uploads/<?php echo htmlspecialchars($product['filename']); ?>" alt="Product Image">
    <h2><?php echo htmlspecialchars($product['name']); ?></h2>
    <h3>₱<?php echo number_format($product['price'], 2); ?></h3>
    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>

    <a href="item.php" class="back-button">← Back</a>
</div>

</body>
</html>
<?php
$pdo = new PDO("mysql:host=localhost;dbname=db_image;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "Product not found.";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM tbl_image WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "Product not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #2b2b2b;
            color: #f4f4f4;
        }

        .product-detail {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: #1a1d23;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            text-align: center;
            animation: fadeIn 0.6s ease-in-out;
        }

        .product-detail img {
            max-width: 200px;
            width: 100%;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .product-detail h2 {
            color: #ffd700;
            margin: 10px 0;
            font-size: 1.5rem;
        }

        .product-detail h3 {
            color: #f1c40f;
            font-size: 1.2rem;
            margin: 5px 0 10px;
        }

        .product-detail p {
            color: #ccc;
            font-size: 0.95rem;
            line-height: 1.4;
        }

        .back-button {
            margin-top: 20px;
            display: inline-block;
            background-color: #ffd700;
            color: #2b2b2b;
            padding: 8px 18px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 0 6px #ffd700;
            transition: 0.3s ease;
        }

        .back-button:hover {
            background-color: #333;
            color: #ffd700;
            box-shadow: 0 0 8px #fff176;
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

        @media (max-width: 500px) {
            .product-detail {
                margin: 20px 10px;
                padding: 15px;
            }
            .product-detail h2 {
                font-size: 1.2rem;
            }
            .product-detail h3 {
                font-size: 1rem;
            }
            .product-detail p {
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>

<div class="product-detail">
    <img src="uploads/<?php echo htmlspecialchars($product['filename']); ?>" alt="Product Image">
    <h2><?php echo htmlspecialchars($product['name']); ?></h2>
    <h3>₱<?php echo number_format($product['price'], 2); ?></h3>
    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>

    <a href="item.php" class="back-button">← Back</a>
</div>

</body>
</html>
<?php
$pdo = new PDO("mysql:host=localhost;dbname=db_image;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "Product not found.";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM tbl_image WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "Product not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #2b2b2b;
            color: #f4f4f4;
        }

        .product-detail {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: #1a1d23;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            text-align: center;
            animation: fadeIn 0.6s ease-in-out;
        }

        .product-detail img {
            max-width: 200px;
            width: 100%;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .product-detail h2 {
            color: #ffd700;
            margin: 10px 0;
            font-size: 1.5rem;
        }

        .product-detail h3 {
            color: #f1c40f;
            font-size: 1.2rem;
            margin: 5px 0 10px;
        }

        .product-detail p {
            color: #ccc;
            font-size: 0.95rem;
            line-height: 1.4;
        }

        .back-button {
            margin-top: 20px;
            display: inline-block;
            background-color: #ffd700;
            color: #2b2b2b;
            padding: 8px 18px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 0 6px #ffd700;
            transition: 0.3s ease;
        }

        .back-button:hover {
            background-color: #333;
            color: #ffd700;
            box-shadow: 0 0 8px #fff176;
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

        @media (max-width: 500px) {
            .product-detail {
                margin: 20px 10px;
                padding: 15px;
            }
            .product-detail h2 {
                font-size: 1.2rem;
            }
            .product-detail h3 {
                font-size: 1rem;
            }
            .product-detail p {
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>

<div class="product-detail">
    <img src="uploads/<?php echo htmlspecialchars($product['filename']); ?>" alt="Product Image">
    <h2><?php echo htmlspecialchars($product['name']); ?></h2>
    <h3>₱<?php echo number_format($product['price'], 2); ?></h3>
    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>

    <a href="item.php" class="back-button">← Back</a>
</div>

</body>
</html>
