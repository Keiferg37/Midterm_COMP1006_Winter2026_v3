<?php
require "connect.php";

// make sure an id was passed in the URL
if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$id = $_GET['id'];

// check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // sanitize the input
    $title = htmlspecialchars(trim($_POST['title']));
    $author = htmlspecialchars(trim($_POST['author']));
    $rating = trim($_POST['rating']);
    $review_text = htmlspecialchars(trim($_POST['review_text']));

    // check if any fields are empty
    if (empty($title) || empty($author) || empty($rating) || empty($review_text)) {
        die("All fields are required. <a href='edit.php?id=$id'>Go back</a>");
    }

    // check that rating is valid
    if (!is_numeric($rating) || $rating < 1 || $rating > 5) {
        die("Rating must be a number between 1 and 5. <a href='edit.php?id=$id'>Go back</a>");
    }

    // update the review in the database
    $sql = "UPDATE reviews SET title = :title, author = :author, rating = :rating, review_text = :review_text WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":title" => $title,
        ":author" => $author,
        ":rating" => $rating,
        ":review_text" => $review_text,
        ":id" => $id
    ]);

    // redirect back to admin page
    header("Location: admin.php");
    exit;
}

// get the review from the database so we can fill the form
$sql = "SELECT * FROM reviews WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([":id" => $id]);
$review = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$review) {
    die("Review not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Review</title>
</head>
<body>
<h1>Edit Review</h1>
<p><a href="admin.php">Back to Admin</a></p>

<form method="POST" action="edit.php?id=<?= $id ?>">

    <label for="title">Book Title:</label>
    <input type="text" id="title" name="title" value="<?= $review['title'] ?>">

    <label for="author">Author:</label>
    <input type="text" id="author" name="author" value="<?= $review['author'] ?>">

    <label for="rating">Rating (1 to 5):</label>
    <input type="number" id="rating" name="rating" min="1" max="5" value="<?= $review['rating'] ?>">

    <label for="review_text">Review:</label>
    <textarea id="review_text" name="review_text" rows="6" cols="40"><?= $review['review_text'] ?></textarea>

    <button type="submit">Save Changes</button>

</form>

</body>
</html>