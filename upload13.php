<?php
session_start();

$pdo = new PDO("mysql:host=localhost;dbname=db_image;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Handle image upload
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $filename = $_FILES['image']['name'];
    $tempname = $_FILES['image']['tmp_name'];
    $filetype = $_FILES['image']['type'];

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($filetype, $allowedTypes)) {
        die("Only JPG, PNG, and GIF files are allowed.");
    }

    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $uniqueName = uniqid('img_', true) . '.' . $ext;
    $folder = "uploads/" . $uniqueName;

    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? '';
    $description = $_POST['description'] ?? '';
    $quantity = $_POST['quantity'] ?? 0;

    if (move_uploaded_file($tempname, $folder)) {
        $stmt = $pdo->prepare("INSERT INTO tbl_image (filename, name, price, description, quantity)
                               VALUES (:filename, :name, :price, :description, :quantity)");
        $stmt->execute([
            'filename' => $uniqueName,
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'quantity' => $quantity
        ]);
        $_SESSION['success_upload'] = "Product uploaded successfully!";
        header('Location: upload13.php');
        exit;
    } else {
        echo "Failed to upload image.";
    }
}

// Fetch existing products
$products = $pdo->query("SELECT * FROM tbl_image ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Upload Manager</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #eee;
            padding: 20px;
            margin: 0;
        }

        .container {
            background: #1e1e1e;
            padding: 30px;
            max-width: 900px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(241, 196, 15, 0.3);
            border: 1px solid #333;
        }

        h2 {
            text-align: center;
            color: #f1c40f;
            margin-bottom: 25px;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-shadow: 0 0 8px #f1c40f;
        }

        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px 20px;
            margin-bottom: 40px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        form textarea {
            grid-column: span 2;
        }

        form button {
            grid-column: span 2;
            justify-self: center;
        }

        input, textarea {
            padding: 8px 10px;
            font-size: 0.95em;
            width: 100%;
            border: 1px solid #444;
            border-radius: 6px;
            background-color: #2a2a2a;
            color: #eee;
            transition: border-color 0.3s ease;
            resize: vertical;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #f1c40f;
            box-shadow: 0 0 8px #f1c40f;
            background-color: #333;
        }

        input::placeholder, textarea::placeholder {
            color: #bbb;
            font-style: italic;
        }

        button {
            width: 160px;
            padding: 10px;
            background-color: #f1c40f;
            border: none;
            color: #121212;
            font-weight: 700;
            cursor: pointer;
            border-radius: 8px;
            box-shadow: 0 0 8px #f1c40f;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        button:hover {
            background-color: #d4ac0d;
            box-shadow: 0 0 12px #d4ac0d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #1e1e1e;
            color: #eee;
            box-shadow: 0 0 12px rgba(241, 196, 15, 0.25);
            border-radius: 10px;
            overflow: hidden;
        }

        thead tr {
            background-color: #333;
        }

        th, td {
            border-bottom: 1px solid #333;
            padding: 12px 15px;
            text-align: center;
            font-weight: 600;
            letter-spacing: 0.03em;
        }

        th {
            color: #f1c40f;
        }

        tbody tr:hover {
            background-color: #2a2a2a;
        }

        img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #f1c40f;
            box-shadow: 0 0 6px #f1c40f;
        }

        .back-btn {
            margin-bottom: 25px;
        }

        .back-btn a {
            text-decoration: none;
            background: #333;
            color: #f1c40f;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            display: inline-block;
            box-shadow: 0 0 6px #f1c40f;
            transition: background-color 0.3s ease;
        }

        .back-btn a:hover {
            background: #d4ac0d;
            color: #121212;
            box-shadow: 0 0 10px #d4ac0d;
        }

        tbody {
            max-height: 400px;
            overflow-y: auto;
            display: block;
        }

        tbody tr {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        thead, tbody tr {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .btn-action {
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: transparent;
            border: 1px solid #f1c40f;
            color: #f1c40f;
        }

        .btn-action:hover {
            background-color: #f1c40f;
            color: #121212;
        }

        .btn-action.delete {
            border-color: #e74c3c;
            color: #e74c3c;
        }

        .btn-action.delete:hover {
            background-color: #e74c3c;
            color: #fff;
        }

        .popup-success {
            position: fixed;
            top: -60px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #27ae60;
            color: #fff;
            padding: 16px 30px;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 4px 12px rgba(39, 174, 96, 0.8);
            font-weight: 700;
            font-size: 1rem;
            z-index: 9999;
            user-select: none;
            opacity: 0;
            pointer-events: none;
            transition: all 0.5s ease;
        }

        .popup-success.show {
            top: 0;
            opacity: 1;
            pointer-events: auto;
        }
    </style>
</head>
<body>

<?php if (isset($_SESSION['success_upload'])): ?>
<div id="popup-msg" class="popup-success">
    <?php 
        echo htmlspecialchars($_SESSION['success_upload']);
        unset($_SESSION['success_upload']);
    ?>
</div>
<?php endif; ?>

<div class="container">
    <div class="back-btn">
        <a href="shopy.php">←</a>
    </div>

    <h2>Admin Panel - Upload Product</h2>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product Name" required>
        <input type="number" step="0.01" name="price" placeholder="Price" required>
        <input type="number" name="quantity" placeholder="Quantity" required>
        <input type="file" name="image" accept="image/*" required>
        <textarea name="description" placeholder="Product Description" required></textarea>
        <button type="submit">Upload Product</button>
    </form>

    <h3>Uploaded Products</h3>
    <table>
        <thead>
        <tr>
            <th>Preview</th>
            <th>Name</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($products)): ?>
            <tr><td colspan="5">No products uploaded yet.</td></tr>
        <?php else: ?>
            <?php foreach ($products as $p): ?>
                <tr>
                    <td><img src="uploads/<?php echo htmlspecialchars($p['filename']); ?>" alt="Product"></td>
                    <td><?php echo htmlspecialchars($p['name']); ?></td>
                    <td>₱<?php echo number_format($p['price'], 2); ?></td>
                    <td><?php echo (int)$p['quantity']; ?></td>
                    <td>
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <a href="edit.php?id=<?php echo $p['id']; ?>" class="btn-action edit">Edit</a>
                            <a href="delete.php?id=<?php echo $p['id']; ?>" onclick="return confirm('Are you sure?')" class="btn-action delete">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const popup = document.getElementById("popup-msg");
    if (popup) {
        popup.classList.add("show");
        setTimeout(() => {
            popup.classList.remove("show");
        }, 4000);
    }
});
</script>

</body>
</html>
