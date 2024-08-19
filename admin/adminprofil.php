<?php
include_once '../check-url.php';
require_once '../config/database.php';
require_once '../helper/helper.php';
require '../head.php';
$admin = getuserDetails($connection);
$defaultProfileImage = 'default.png';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        .profile-card {
            border: 2px solid #1e90ff;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            padding: 20px;
            background-color: #ffffff;
            width: 100%;
        }
        .profile-image img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #1e90ff;
        }
        .profile-info h1 {
            color: #1e90ff;
            font-size: 26px;
            margin: 20px 0;
        }
        .profile-info p {
            font-size: 18px;
            color: #555;
        }
        .btn-edit {
            background-color: #1e90ff;
            color: white;
            border: none;
        }
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
        <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <?php if($admin): ?>
            <div class="profile-card">
                <div class="profile-image">
                    <img src="<?php echo $admin['profile'] ? '../uploads/' . htmlspecialchars($admin['profile']) : '../uploads/' . htmlspecialchars($defaultProfileImage); ?>" alt="Profile Image">
                </div>
                <div class="profile-info">
                    <h1><?php echo htmlspecialchars($admin['name']) . ' ' . htmlspecialchars($admin['surname']); ?></h1>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($admin['email']); ?></p>
                    <p><strong>Gender:</strong> <?php echo $admin['gender'] == 1 ? 'Male' : 'Female'; ?></p>
                    <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($admin['dob']); ?></p>
                    <a href="edit_profile_admin.php?id=<?php echo htmlspecialchars($admin['id']); ?>" class="btn btn-edit">Edit Profile</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
        </div>
    </div>
</body>

</html>