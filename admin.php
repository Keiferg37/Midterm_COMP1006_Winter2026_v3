<?php
require "connect.php";

// fetch all reviews from the database
$sql = "SELECT * FROM reviews ORDER BY created_at DESC";
$stmt = $pdo->query($sql);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Book Reviews</title>
</head>
<body>
<h1>Admin - All Reviews</h1>
<p><a href="index.php">Submit a Review</a></p>

<?php if (count($reviews) > 0): ?>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Rating</th>
            <th>Review</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        <!-- loop through each review and display it -->
        <?php foreach ($reviews as $review): ?>
            <tr>
                <td><?= $review['id'] ?></td>
                <td><?= $review['title'] ?></td>
                <td><?= $review['author'] ?></td>
                <td><?= $review['rating'] ?>/5</td>
                <td><?= $review['review_text'] ?></td>
                <td><?= $review['created_at'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $review['id'] ?>">Update</a>
                    <a href="delete.php?id=<?= $review['id'] ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No reviews found.</p>
<?php endif; ?>

</body>
</html>