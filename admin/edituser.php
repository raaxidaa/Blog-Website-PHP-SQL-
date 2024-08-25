<?php
include_once '../check-url.php';
require_once '../config/database.php';
require_once '../helper/helper.php';

$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;


if (isset($_POST['update_status'])) {
    $userId = intval($_POST['user_id']);
    $active = intval($_POST['active']);
    $updateSql = "UPDATE users SET active = :active WHERE id = :id";
    $stmt = $connection->prepare($updateSql);
    $stmt->execute([':active' => $active, ':id' => $userId]);
}

$countSql = "SELECT COUNT(*) AS total FROM users WHERE role = 0";
$countStmt = $connection->query($countSql);
$totalUsers = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = ceil($totalUsers / $limit);

$sql = "SELECT * FROM users WHERE role = 0 LIMIT :limit OFFSET :offset";
$stmt = $connection->prepare($sql);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
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

        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination a {
            margin: 0 5px;
            text-decoration: none;
            color: black;
        }

        .pagination .active {
            font-weight: bold;
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
            <h1>User Management</h1>
            <div class="search-bar">
                <input type="text" placeholder="Search...">
            </div>
        </div>
        <div class="content">
            <h2>Users Edit</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo $user['active'] ? 'Active' : 'Inactive'; ?></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <input type="hidden" name="active" value="<?php echo $user['active'] ? 0 : 1; ?>">
                                    <button type="submit" name="update_status" class="status-toggle">
                                        <?php echo $user['active'] ? 'Deactivate' : 'Activate'; ?>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>">« Previous</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?php echo $page + 1; ?>">Next »</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
