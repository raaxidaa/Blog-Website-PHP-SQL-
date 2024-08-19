<?php
include_once '../check-url.php';
require_once '../config/database.php';
require_once '../helper/helper.php';
require '../head.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/src/PHPMailer.php';
require '../vendor/src/Exception.php';
require '../vendor/src/SMTP.php';
$userId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user = null;
if ($userId > 0) {
    $stmt = $connection->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = ValidationLogin(['password', 'name', 'password_confirmation', 'surname', 'gender', 'dob']);
    
    $name = post('name');
    $password = post('password');
    $password_confirmation = post('password_confirmation');
    $surname = post('surname');
    $gender = post('gender');
    $dob = post('dob');
    $image = $user['profile']; 

    if (!empty($_FILES['image']['name'])) {
        $image = file_upload('../uploads', $_FILES['image']);
        if (!$image) {
            $errors['image'] = 'Image upload failed. Please try again.';
        }
    }
    
    if ($password == $password_confirmation && count($errors) === 0) {
        $passwordHash = $password ? password_hash($password, PASSWORD_DEFAULT) : $user['password'];
        $sql = "UPDATE users SET name = ?, surname = ?, password = ?, gender = ?, dob = ?, profile = ? WHERE id = ?";
        
        try {
            $loginQuery = $connection->prepare($sql);
            $check = $loginQuery->execute([
                $name,
                $surname,
                $passwordHash,
                $gender,
                $dob,
                $image,
                $userId
            ]);

            if ($check) {
                header('Location: main.php'); 
                exit();
            }
        } catch (Exception $e) {
            echo $e;
        }
    } else {
        $errors['password'] = 'Passwords do not match or there are other errors.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        .container {
            padding: 20px;
        }
        .btn-primary {
            background-color: #1e90ff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: #1c86ee;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .error-message {
            color: red;
            margin-top: 5px;
        }
        .current-image {
            margin-bottom: 15px;
        }
        .current-image img {
            max-width: 200px;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Profile</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <?php if ($user['profile']): ?>
                <div class="form-group current-image">
                    <label>Current Profile Image</label>
                    <img src="../uploads/<?php echo htmlspecialchars($user['profile']); ?>" alt="Profile Image">
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="surname">Surname</label>
                <input type="text" name="surname" value="<?php echo htmlspecialchars($user['surname']); ?>" required>
            </div>
            <div class="form-group">
                <label for="dob">DOB</label>
                <input type="date" name="dob" value="<?php echo htmlspecialchars($user['dob']); ?>" required>
            </div>
            <div class="form-group">
                <label for="image">Profile Image (optional)</label>
                <input type="file" name="image">
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select name="gender" id="gender" required>
                    <option value="1" <?php echo $user['gender'] == 1 ? 'selected' : ''; ?>>Male</option>
                    <option value="2" <?php echo $user['gender'] == 2 ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password">
                <?php if (isset($errors["password"])) { ?>
                    <div class="error-message"><?php echo $errors['password']; ?></div>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Password Confirmation</label>
                <input type="password" name="password_confirmation">
            </div>
            <div class="form-group">
                <button class="btn-primary" type="submit">Save Changes</button>
            </div>
        </form>
    </div>
</body>
</html>
