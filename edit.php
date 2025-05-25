<?php
session_start();  // <- kailangan para sa session

$host = 'localhost';
$dbname = 'db_image';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!isset($_GET['id']) || empty($_GET['id'])) {
        die("ID not provided.");
    }

    $id = (int)$_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM tbl_image WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $image = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$image) {
        die("Product not found.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $quantity = $_POST['quantity'];
        $newFilename = $image['filename'];

        if (!empty($_FILES['image']['name'])) {
            $newFilename = uniqid('img_', true) . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $tempname = $_FILES['image']['tmp_name'];
            $folder = "folder/" . $newFilename;

            if (move_uploaded_file($tempname, $folder)) {
                $oldPath = "folder/" . $image['filename'];
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            } else {
                echo "Failed to upload new image.";
                exit;
            }
        }

        $stmt = $pdo->prepare("UPDATE tbl_image SET filename = :filename, name = :name, price = :price, description = :description, quantity = :quantity WHERE id = :id");
        $stmt->execute([
            'filename' => $newFilename,
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'quantity' => $quantity,
            'id' => $id
        ]);

        // Set success message to session
        $_SESSION['success_upload'] = "Product updated successfully!";

        // Redirect back to upload13.php so popup appears there
        header("Location: upload13.php");
        exit;
    }

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <style>
        * {
    box-sizing: border-box;
}

body {
    margin: 0;
    padding: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #121212;
    color: #f1c40f;
    font-style: oblique;
}

h2 {
    text-align: center;
    color: #f1c40f;
    margin-bottom: 20px;
    text-shadow: 0 0 5px #f1c40f99;
}

.container {
    background: #222; /* dark container bg */
    padding: 25px;
    border-radius: 12px;
    max-width: 500px;
    margin: 0 auto;
    box-shadow: 0 0 20px 3px #f1c40f44;
    border: 1px solid #f1c40f55;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #f1c40f;
    text-shadow: 0 0 3px #f1c40f99;
}

input[type="file"],
input[type="text"],
input[type="number"],
textarea {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 1.5px solid #f1c40f88;
    border-radius: 8px;
    background-color: #333;
    color: #f1c40f;
    font-weight: 600;
    box-shadow: inset 0 0 8px #f1c40f22;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
    font-size: 16px;
    font-family: inherit;
}

input[type="file"] {
    padding: 6px 12px;
}

input[type="text"]:focus,
input[type="number"]:focus,
textarea:focus,
input[type="file"]:focus {
    outline: none;
    border-color: #f1c40f;
    box-shadow: 0 0 8px #f1c40fcc;
    background-color: #2a2a2a;
    color: #f1c40f;
}

button {
    background: linear-gradient(180deg, #f1c40f, #b38f00);
    color: #222;
    padding: 14px;
    border: none;
    border-radius: 12px;
    font-weight: bold;
    cursor: pointer;
    width: 100%;
    font-size: 18px;
    text-shadow: 0 0 4px #7b6b00;
    transition: background 0.3s ease;
    box-shadow: 0 4px 15px #f1c40faa;
}

button:hover {
    background: linear-gradient(180deg, #b38f00, #f1c40f);
    box-shadow: 0 6px 20px #f1c40fff;
}

a {
    display: inline-block;
    margin-top: 15px;
    text-align: center;
    background-color: #f1c40f;
    color: #121212;
    padding: 12px 20px;
    text-decoration: none;
    border-radius: 12px;
    font-weight: 700;
    transition: background-color 0.3s ease, color 0.3s ease;
    box-shadow: 0 0 12px #f1c40fbb;
}

a:hover {
    background-color: #b38f00;
    color: #eee;
    box-shadow: 0 0 15px #b38f00cc;
}

img {
    display: block;
    max-width: 100%;
    height: auto;
    border: 2px solid #f1c40f;
    border-radius: 12px;
    margin-bottom: 20px;
    box-shadow: 0 0 10px #f1c40f88;
}

@media screen and (max-width: 768px) {
    .container {
        width: 90%;
        padding: 20px;
    }

    button, a {
        font-size: 16px;
    }
}

    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Product</h2>
        <form method="post" enctype="multipart/form-data">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($image['name']) ?>" required>

            <label for="price">Price:</label>
            <input type="number" id="price" step="0.01" name="price" value="<?= htmlspecialchars($image['price']) ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4"><?= htmlspecialchars($image['description']) ?></textarea>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" min="0" value="<?= htmlspecialchars($image['quantity']) ?>" required>

            <p><strong>Current Image:</strong></p>
            <img src="folder/<?= htmlspecialchars($image['filename']) ?>" alt="Current Product Image" width="150">

            <label for="image">Change Image (optional):</label>
            <input type="file" id="image" name="image">

            <button type="submit">Save Changes</button>
            <a href="upload13.php">Cancel</a>
        </form>
    </div>
</body>
</html>
