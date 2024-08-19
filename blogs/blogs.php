<?php 
include_once '../index.php';

$title = isset($_GET['title']) ? $_GET['title'] : '';
$description = isset($_GET['description']) ? $_GET['description'] : '';
$authorName = isset($_GET['author']) ? $_GET['author'] : '';
$category = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$query = "SELECT blogs.*, users.name AS author_name
FROM blogs
JOIN users ON blogs.user_id = users.id
WHERE blogs.is_publish = 1";
$conditions = [];
$params = [];

if (!empty($title)) {
    $conditions[] = "blogs.title LIKE ?";
    $params[] = "%$title%";
}
if (!empty($description)) {
    $conditions[] = "blogs.description LIKE ?";
    $params[] = "%$description%";
}
if (!empty($authorName)) {
    $conditions[] = "users.name LIKE ?";
    $params[] = "%$authorName%";
}
if ($category > 0) {
    $conditions[] = "blogs.category_id = ?";
    $params[] = $category;
}

if (count($conditions) > 0) {
    $query .= " AND " . implode(" AND ", $conditions);
}

$query .= " ORDER BY blogs.view_count DESC";

$blogsquery = $connection->prepare($query);
$blogsquery->execute($params);
$blogs = $blogsquery->fetchAll(PDO::FETCH_ASSOC);

$categorySql = "SELECT id, name FROM categories";
$categoryStmt = $connection->query($categorySql);
$categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Search</title>
    <style>
        button a {
            color: white;
            text-decoration: none;
        }
        button {
            margin-top: 20px;
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin: 20px;
            max-width: 300px;
            height: 400px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: inline-block;
            position: relative;
        }
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }
        .card-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .btn {
            text-decoration: none;
            color: #fff;
            border-radius: 4px;
            padding: 5px 10px;
            font-size: 14px;
            display: inline-block;
        }
        .btn-warning {
            background-color: #ffc107;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .cards {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        .blogs {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            padding-top: 30px;
            justify-content: center;
        }
        h3 {
            padding-top: 20px;
        }
        .search {
            margin-bottom: 20px;
        }
        .search input, .search select {
            margin-right: 10px;
            padding: 5px;
        }
    </style>
</head>
<body>
    <button><a href="insertblog.php">Create Blog</a></button>
    <button><a href="usersblog.php">My blogs</a></button>
    <button><a href="lastblog.php">Last 5 blogs</a></button>
    <button><a href="top3blog.php">Top 3 blogs</a></button>

    <div class="search">
        <form method="get" action="">
            <input type="text" name="title" placeholder="Title" value="<?php echo htmlspecialchars($title); ?>">
            <input type="text" name="description" placeholder="Description" value="<?php echo htmlspecialchars($description); ?>">
            <input type="text" name="author" placeholder="Author" value="<?php echo htmlspecialchars($authorName); ?>">
            <select name="category">
                <option value="">Select Category</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo htmlspecialchars($cat['id']); ?>" <?php echo ($cat['id'] == $category) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Search</button>
        </form>
    </div>

    <h3>All Blogs</h3>
    <div class="blogs">
        <?php
        if (count($blogs) > 0) {
            foreach ($blogs as $blog) {
                echo "<div class='card'>";
                echo "<img src='../uploads/" . htmlspecialchars($blog['blog_img']) . "' alt='" . htmlspecialchars($blog['title']) . "'>";
                echo "<h3>" . htmlspecialchars($blog['title']) . "</h3>";
                echo "<p>" . htmlspecialchars($blog['description']) . "</p>";
                echo "<p class='author'>Author: " . htmlspecialchars($blog['author_name']) . "</p>";
                echo "</div>"; 
            }
        } else {
            echo "<p>No blogs found.</p>";
        }
        ?>
    </div>
</body>
</html>
