<?php
include_once '../check-url.php';
require_once '../config/database.php';
require_once '../helper/helper.php';


if (isset($_POST['update_status'])) {
    $blogId = intval($_POST['blog_id']);
    $isPublished = intval($_POST['is_publish']);
    $updateSql = "UPDATE blogs SET is_publish = :is_publish WHERE id = :id";
    $stmt = $connection->prepare($updateSql);
    $stmt->execute([':is_publish' => $isPublished, ':id' => $blogId]);
}

$sql = "SELECT * FROM blogs";
$stmt = $connection->query($sql);
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Management</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        .status-toggle {
            cursor: pointer;
            color: blue;
            text-decoration: underline;
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
            <h1>Blog Management</h1>
            <div class="search-bar">
                <input type="text" placeholder="Search...">
            </div>
        </div>
        <div class="content">
            <h2>Blogs Edit</h2>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($blogs as $blog): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($blog['title']); ?></td>
                            <td><?php echo htmlspecialchars($blog['description']); ?></td>
                            <td><?php echo $blog['is_publish'] ? 'Published' : 'Unpublished'; ?></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="blog_id" value="<?php echo $blog['id']; ?>">
                                    <input type="hidden" name="is_publish" value="<?php echo $blog['is_publish'] ? 0 : 1; ?>">
                                    <button type="submit" name="update_status" class="status-toggle">
                                        <?php echo $blog['is_publish'] ? 'Unpublish' : 'Publish'; ?>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
