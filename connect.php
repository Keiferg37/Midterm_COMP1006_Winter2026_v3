<?php
// connect to the database using PDO
try {
    $pdo = new PDO("mysql:host=localhost;dbname=book_manager", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>