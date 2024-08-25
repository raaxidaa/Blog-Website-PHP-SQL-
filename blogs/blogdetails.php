<?php 
include_once '../index.php';

$blogId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$query = "
    SELECT blogs.*, users.name AS author_name, users.email AS author_email, categories.name AS category_name
    FROM blogs
    JOIN users ON blogs.user_id = users.id
    JOIN categories ON blogs.category_id = categories.id
    WHERE blogs.id = ?
";
$stmt = $connection->prepare($query);
$stmt->execute([$blogId]);
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$blog) {
    echo "<p>Blog not found.</p>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <div class="mb-4">
            <a href="blogs.php" class="btn btn-secondary">Back</a>
        </div>

        <h1><?php echo htmlspecialchars($blog['title']); ?></h1>
        <p><strong>Author:</strong> <?php echo htmlspecialchars($blog['author_name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($blog['author_email']); ?></p>
        <p><strong>Category:</strong> <?php echo htmlspecialchars($blog['category_name']); ?></p>
        <p><?php echo nl2br(htmlspecialchars($blog['description'])); ?></p>
        <?php if (!empty($blog['blog_img'])): ?>
            <img src="../uploads/<?php echo htmlspecialchars($blog['blog_img']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($blog['title']); ?>">
        <?php endif; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
