<?php 
include_once '../index.php';
$query = "SELECT * FROM blogs WHERE is_publish = 1 ORDER BY view_count DESC LIMIT 3";
$blogsquery = $connection->prepare($query);
$blogsquery->execute([]);
$blogs = $blogsquery->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        button a{
            color: white;
        }
        button{
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
        .card p{
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
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
        .blogs{
            display: flex;
            align-items: center;
           flex-wrap: wrap;
           gap: 20px;
           padding-top: 30px;
           justify-content: center;
        }
        h3{
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <h3>Top 3 Blogs </h3>
    <div class="blogs">
    <?php
    if (count($blogs) > 0) {
        foreach ($blogs as $blog) {
            echo "<div class='card'>";
            echo "<img src='../uploads/" . htmlspecialchars($blog['blog_img']) . "' alt='" . htmlspecialchars($blog['title']) . "'>";
            echo "<h3>" . htmlspecialchars($blog['title']) . "</h3>";
            echo "<p>" . htmlspecialchars($blog['description']) . "</p>";
            echo "<a href='blogdetails.php?id=" . htmlspecialchars($blog['id']) . "' class='btn btn-primary'>Read More</a>";
            echo "</div>"; 
        }
    }
    ?>
    </div>
</body>
</html>