<?php
require "connect.php";

// sanitize the form inputs
$title = htmlspecialchars(trim($_POST['title']));
$author = htmlspecialchars(trim($_POST['author']));
$rating = trim($_POST['rating']);
$review_text = htmlspecialchars(trim($_POST['review_text']));

// check if any fields are empty
if (empty($title) || empty($author) || empty($rating) || empty($review_text)) {
    die("All fields are required. <a href='index.php'>Go back</a>");
}

// check that rating is a valid number
if (!is_numeric($rating) || $rating < 1 || $rating > 5) {
    die("Rating must be a number between 1 and 5. <a href='index.php'>Go back</a>");
}

// insert the review into the database using a prepared statement
$sql = "INSERT INTO reviews (title, author, rating, review_text) VALUES (:title, :author, :rating, :review_text)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ":title" => $title,
    ":author" => $author,
    ":rating" => $rating,
    ":review_text" => $review_text
]);

// redirect back to the form
header("Location: index.php");
exit;
?>