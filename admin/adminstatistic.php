<?php
include_once '../check-url.php';
require_once '../config/database.php';
require_once '../helper/helper.php';
 
$today = date('Y-m-d');
$startOfWeek = date('Y-m-d');
$startOfMonth = date('Y-m-01');

$sql = "SELECT COUNT(*) AS count FROM blogs WHERE DATE(created_at) = ?";
$stmt = $connection->prepare($sql);
$stmt->execute([$today]);
$dailyBlogsResult = $stmt->fetch(PDO::FETCH_ASSOC);
$dailyBlogs = $dailyBlogsResult['count'];


$sql = "SELECT COUNT(*) AS count FROM blogs WHERE DATE(created_at) >= ?";
$stmt = $connection->prepare($sql);
$stmt->execute([$startOfWeek]);
$weeklyBlogsResult = $stmt->fetch(PDO::FETCH_ASSOC);
$weeklyBlogs = $weeklyBlogsResult['count'];


$sql = "SELECT COUNT(*) AS count FROM blogs WHERE DATE(created_at) >= ?";
$stmt = $connection->prepare($sql);
$stmt->execute([$startOfMonth]);
$monthlyBlogsResult = $stmt->fetch(PDO::FETCH_ASSOC);
$monthlyBlogs = $monthlyBlogsResult['count'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #333;
            color: white;
            padding: 20px;
            position: fixed;
        }

        .sidebar h2 {
            margin-top: 0;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .sidebar a:hover {
            background-color: #555;
        }

        .main-content {
            margin-left: 300px;
            padding: 20px;
            width: calc(100% - 250px);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f4f4f4;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
        }

        .header h1 {
            margin: 0;
        }

        .header .search-bar input {
            padding: 5px;
            font-size: 16px;
        }

        .content {
            margin-top: 20px;
        }

        .content h2 {
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .box {
            margin: 20px 0;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .box h3 {
            margin-top: 0;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="adminprofil.php">Profile</a>
        <a href="category.php">Manage Category</a>
        <a href="acceptblog.php">Manage Blogs</a>
        <a href="edituser.php">Manage Users</a>
        <a href="adminstatistic.php">Statistic</a>
        <a href="adminlogout.php">Log out</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Dashboard</h1>
            <div class="search-bar">
                <input type="text" placeholder="Search...">
            </div>
        </div>
        <div class="content">
            <h2>Statistics</h2>
            
            <div class="box">
                <h3>Daily Blogs</h3>
                <p><?php echo htmlspecialchars($dailyBlogs); ?> blogs</p>
            </div>
            <div class="box">
                <h3>Weekly Blogs</h3>
                <p><?php echo htmlspecialchars($weeklyBlogs); ?> blogs</p>
            </div>
            <div class="box">
                <h3>Monthly Blogs</h3>
                <p><?php echo htmlspecialchars($monthlyBlogs); ?> blogs</p>
            </div>
        </div>
    </div>
</body>

</html>
