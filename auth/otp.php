<?php
include_once '../index.php';
$errors=[];
if($_SERVER['REQUEST_METHOD']=="POST"){
    $errors=ValidationLogin(["otp"]);
    if(count($errors )===0){
        $otp=post('otp');
        $confirmation_otp= $_SESSION['otp'];
        $otp_ttl=$_SESSION['otp_ttl'];
        $user_email= $_SESSION['otp_email'];
        if(time()<= $otp_ttl){
          if($otp ==$confirmation_otp){
            $sql= "UPDATE users SET otp = NULL WHERE email=?";
            $updateQuery=$connection->prepare($sql);
            $check = $updateQuery->execute([
                $user_email
            ]);
            if($check){
                $_SESSION=[];
                view(route("auth/login.php"));
            }
          }
        }

    }
}


?>

<div class="container">
    <div class="row"
        style="display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 20px;">
        <div class="col-8"
            style="display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 20px;">

            <form action="" method="post">
                <div>
                    <label for="otp">OTP Confirmation</label>
                    <input type="number" name="otp">
                    <?php if (isset($errors["otp"])) { ?>
                        <span style="color:red;"> <?php echo $errors["otp"]; ?></span>
                    <?php } ?>
                </div>
                <div>
                    <button class="btn btn-primary" type="submit">OTP Submit</button>
                </div>

            </form>
        </div>
    </div>
    <?php
    include_once '../footer.php';
    ?>