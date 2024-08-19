<?php
include_once '../index.php';
$user = getUserDetails($connection);
$defaultProfileImage = 'default.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6f2ff;
        }
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
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <?php if($user): ?>
            <div class="profile-card">
                <div class="profile-image">
                    <img src="<?php echo $user['profile'] ? '../uploads/' . htmlspecialchars($user['profile']) : '../uploads/' . htmlspecialchars($defaultProfileImage); ?>" alt="Profile Image">
                </div>
                <div class="profile-info">
                    <h1><?php echo htmlspecialchars($user['name']) . ' ' . htmlspecialchars($user['surname']); ?></h1>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>Gender:</strong> <?php echo $user['gender'] == 1 ? 'Male' : 'Female'; ?></p>
                    <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($user['dob']); ?></p>
                    <a href="edit_profile.php?id=<?php echo htmlspecialchars($user['id']); ?>"  class="btn btn-edit">Edit Profile</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
