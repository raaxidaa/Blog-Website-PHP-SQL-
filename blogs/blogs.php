<?php 
include_once '../index.php';

$title = isset($_GET['title']) ? $_GET['title'] : '';
$description = isset($_GET['description']) ? $_GET['description'] : '';
$authorName = isset($_GET['author']) ? $_GET['author'] : '';
$category = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 6;
$offset = ($page - 1) * $limit;

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
$query .= " ORDER BY blogs.view_count DESC LIMIT $limit OFFSET $offset";

$blogsquery = $connection->prepare($query);
$blogsquery->execute($params);
$blogs = $blogsquery->fetchAll(PDO::FETCH_ASSOC);


$countQuery = "SELECT COUNT(*) AS total FROM blogs JOIN users ON blogs.user_id = users.id WHERE blogs.is_publish = 1";
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
    $countQuery .= " AND " . implode(" AND ", $conditions);
}

$countStmt = $connection->prepare($countQuery);
$countStmt->execute($params);
$totalBlogs = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = ceil($totalBlogs / $limit);

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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            height: 400px; 
        }
        .card img {
            height: 200px;
            object-fit: cover;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .card-title {
            margin-bottom: 10px;
            font-size: 1.25rem;
        }
        .card-text {
            flex-grow: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .search input, .search select {
            margin-right: 10px;
        }
        .search {
            margin-bottom: 20px;
        }
        .search form {
            width: 100%;
        }
        .search form input {
            width: 100%;
            margin-right: 10px;
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="mb-4">
            <a href="insertblog.php" class="btn btn-primary">Create Blog</a>
            <a href="usersblog.php" class="btn btn-secondary">My blogs</a>
            <a href="lastblog.php" class="btn btn-info">Last 5 blogs</a>
            <a href="top3blog.php" class="btn btn-warning">Top 3 blogs</a>
        </div>

        <div class="search mb-4">
            <form method="get" action="">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <input type="text" name="title" class="form-control" placeholder="Title" value="<?php echo htmlspecialchars($title); ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" name="description" class="form-control" placeholder="Description" value="<?php echo htmlspecialchars($description); ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" name="author" class="form-control" placeholder="Author" value="<?php echo htmlspecialchars($authorName); ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <select name="category" class="form-control">
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo htmlspecialchars($cat['id']); ?>" <?php echo ($cat['id'] == $category) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>

        <h3>All Blogs</h3>
        <div class="row">
            <?php
            if (count($blogs) > 0) {
                foreach ($blogs as $blog) {
                    echo "<div class='col-md-4'>";
                    echo "<div class='card'>";
                    echo "<img src='../uploads/" . htmlspecialchars($blog['blog_img']) . "' alt='" . htmlspecialchars($blog['title']) . "' class='card-img-top'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . htmlspecialchars($blog['title']) . "</h5>";
                    echo "<p class='card-text'>" . htmlspecialchars($blog['description']) . "</p>";
                    echo "<a href='blogdetails.php?id=" . htmlspecialchars($blog['id']) . "' class='btn btn-primary'>Read More</a>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No blogs found.</p>";
            }
            ?>
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?title=<?php echo urlencode($title); ?>&description=<?php echo urlencode($description); ?>&author=<?php echo urlencode($authorName); ?>&category=<?php echo $category; ?>&page=<?php echo $page - 1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?title=<?php echo urlencode($title); ?>&description=<?php echo urlencode($description); ?>&author=<?php echo urlencode($authorName); ?>&category=<?php echo $category; ?>&page=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?title=<?php echo urlencode($title); ?>&description=<?php echo urlencode($description); ?>&author=<?php echo urlencode($authorName); ?>&category=<?php echo $category; ?>&page=<?php echo $page + 1; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
