<?php
session_start();

$host = 'localhost';
$dbname = 'db_image';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!isset($_GET['id'])) {
        die("ID not provided.");
    }
    $id = (int)$_GET['id'];

    // Get image filename to delete physical file
    $stmt = $pdo->prepare("SELECT filename FROM tbl_image WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $image = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$image) {
        die("Image not found.");
    }

    $filePath = 'folder/' . $image['filename'];
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    // Delete from database
    $delete = $pdo->prepare("DELETE FROM tbl_image WHERE id = :id");
    $delete->execute(['id' => $id]);

    // Set session message
    $_SESSION['success_delete'] = "Product deleted successfully!";
    header('Location: upload13.php');
    exit;

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
