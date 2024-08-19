<?php
include_once '../index.php';

$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = ValidationLogin(['email', 'password']);

    if (empty($errors)) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $loginQuery = $connection->prepare($sql);
        $loginQuery->execute([$_POST['email']]);
        $user = $loginQuery->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($user['active'] == 0) {
                $errors['login'] = "User is inactive. Please contact support.";
            } else if ($user['otp'] != null) {
                $_SESSION['otp_email'] = post("email");
                $_SESSION['otp'] = $user['otp'];
                $_SESSION['otp_ttl'] = time() + 300;
                view(route('auth/otp.php'));
                exit();
            } else if (password_verify($_POST['password'], $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];

                if ($user['role'] == 1) {
                    view(route('admin/adminindex.php'));
                } else if ($user['role'] == 0) {
                    view(route('/user/main.php'));
                }
                exit();
            } else {
                $errors['login'] = "Invalid email or password.";
            }
        } else {
            $errors['login'] = "Invalid email or password.";
        }
    }
}
?>

<div class="container">
    <div>
        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 20px; height: 70vh;">
            <h1>Login Form</h1>
            <form action="" method="post">
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    <?php if (isset($errors["email"])) { ?>
                        <span style="color:red;"> <?php echo $errors['email']; ?></span>
                    <?php } ?>
                </div>

                <div>
                    <label for="password">Password</label>
                    <input type="password" name="password">
                    <?php if (isset($errors["password"])) { ?>
                        <span style="color:red;"> <?php echo $errors['password']; ?></span>
                    <?php } ?>
                </div>

                <div>
                    <button type="submit">Log in</button>
                    <a style="text-decoration: none;color: black" href="register.php">If you don't have a user, go register</a>
                </div>

                <?php if (isset($errors['login'])) { ?>
                    <div style="color:red;"><?php echo $errors['login']; ?></div>
                <?php } ?>
            </form>
        </div>
    </div>
</div>

<?php
include_once '../footer.php';
?>
