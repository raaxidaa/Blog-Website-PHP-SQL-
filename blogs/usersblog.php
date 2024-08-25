<?php
include_once '../index.php';
$id = intval($_SESSION['user_id']);
$query = "SELECT * FROM blogs WHERE user_id = :user_id";
$blogsquery = $connection->prepare($query);
$blogsquery->execute([':user_id' => $id]);
$blogs = $blogsquery->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloglar</title>
    <style>
        body {
            display: flex;
           flex-direction: column;
           gap: 30px;
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin: 20px;
            max-width: 300px;
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
        .cards{
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }
    </style>
</head>
<body>
    <a href="insertblog.php"> New Create blog</a>
   <div class="cards">
   <?php
    if (count($blogs) > 0) {
        foreach ($blogs as $blog) {
            echo "<div class='card'>";
            echo "<img src='../uploads/" . htmlspecialchars($blog['blog_img']) . "' alt='" . htmlspecialchars($blog['title']) . "'>";
            echo "<h3>" . htmlspecialchars($blog['title']) . "</h3>";
            echo "<p>" . htmlspecialchars($blog['description']) . "</p>";
            echo "<div class='card-footer'>";
            echo "<a href='edit_blog.php?id=" . htmlspecialchars($blog['id']) . "' class='btn btn-warning'>Edit</a>";
            echo "<a href='delete_blog.php?id=" . htmlspecialchars($blog['id']) . "' class='btn btn-danger'>Delete</a>";
            echo "</div>"; 
            echo "</div>"; 
        }
    }
    ?>
   </div>
</body>
</html>
