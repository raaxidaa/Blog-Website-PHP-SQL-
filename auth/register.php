<?php
include_once '../index.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/src/PHPMailer.php';
require '../vendor/src/Exception.php';
require '../vendor/src/SMTP.php';

$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = ValidationLogin(['email', 'password', 'name', 'password_confirmation', 'surname', 'gender', 'dob']);

    $name = post('name');
    $email = post('email');
    $password = post('password');
    $password_confirmation = post('password_confirmation');
    $surname = post('surname');
    $gender = post('gender');
    $dob = post('dob');
    $image = null;

    if (!empty($_FILES['image']['name'])) {
        $image = file_upload('../uploads', $_FILES['image']);
        if (!$image) {
            $errors['image'] = 'Image upload failed. Please try again.';
        }
    }

    if ($password == $password_confirmation && count($errors) === 0) {
        $otp = rand(1000, 9999);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, surname, email, password, otp, gender, dob, profile) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        try {
            $loginQuery = $connection->prepare($sql);
            $check = $loginQuery->execute([
                $name,
                $surname,
                $email,
                $password,
                $otp,
                $gender,
                $dob,
                $image
            ]);

            if ($check) {
                $_SESSION['otp_email'] = post("email");
                $_SESSION['otp'] = $otp;
                $_SESSION['otp_ttl'] = time() + 300;

                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'gismathusein@gmail.com';
                    $mail->Password = "byvq pkag depo skiw";
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;
                    $mail->setFrom('gismathusein@gmail.com', 'Blog Website');
                    $mail->addAddress($email); 

                    $mail->isHTML(true);
                    $mail->Subject = 'Website OTP Register';
                    $mail->Body = 'OTP code: ' . $otp;

                    $mail->send();
                } catch (Exception $e) {
                    echo "{$mail->ErrorInfo}";
                }

                view(route("auth/otp.php"));
            }
        } catch (PDOException $e) {
            if ($e->errorInfo[1] === 1062) {
                echo "Email already exists";
            } else {
                echo $e->getMessage();
            }
        }
    } else {
        echo 'Passwords do not match or there are other errors.';
    }
}
?>

<div class="container">
    <div class="row"
        style="display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 20px;">
        <div class="col-8"
            style="display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 20px;">
            <h1>Register Form</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="name">Name</label>
                    <input type="text" name="name">
                    <?php if (isset($errors["name"])) { ?>
                        <span style="color:red;"> <?php echo $errors['name']; ?></span>
                    <?php } ?>
                </div>
                <div>
                    <label for="surname">Surname</label>
                    <input type="text" name="surname">
                    <?php if (isset($errors["surname"])) { ?>
                        <span style="color:red;"> <?php echo $errors['surname']; ?></span>
                    <?php } ?>
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email">
                    <?php if (isset($errors["email"])) { ?>
                        <span style="color:red;"> <?php echo $errors['email']; ?></span>
                    <?php } ?>
                </div>
                <div>
                    <label for="dob">DOB</label>
                    <input type="date" name="dob">
                    <?php if (isset($errors["dob"])) { ?>
                        <span style="color:red;"> <?php echo $errors['dob']; ?></span>
                    <?php } ?>
                </div>
                <div>
                    <label for="image">Profile Image (optional)</label>
                    <input type="file" name="image">
                    <?php if (isset($errors["image"])) { ?>
                        <span style="color:red;"> <?php echo $errors['image']; ?></span>
                    <?php } ?>
                </div>
                <div>
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender">
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                    </select>
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" name="password">
                    <?php if (isset($errors["password"])) { ?>
                        <span style="color:red;"> <?php echo $errors['password']; ?></span>
                    <?php } ?>
                </div>
                <div>
                    <label for="password_confirmation">Password Confirmation</label>
                    <input type="password" name="password_confirmation">
                    <?php if (isset($errors["password_confirmation"])) { ?>
                        <span style="color:red;"> <?php echo $errors["password_confirmation"]; ?></span>
                    <?php } ?>
                </div>
                <div>
                    <button class="btn btn-primary" type="submit">Register</button>
                    <a style="text-decoration: none; color: black" href="login.php">If you have a user, go login</a>
                </div>
            </form>
        </div>
    </div>
    <?php include_once '../footer.php'; ?>
</div>