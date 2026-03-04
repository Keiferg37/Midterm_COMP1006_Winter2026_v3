<?php
require "connect.php";

// check if an id was passed in the URL
if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$id = $_GET['id'];

// delete the review from the database
$sql = "DELETE FROM reviews WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([":id" => $id]);

// redirect back to admin page
header("Location: admin.php");
exit;
?>