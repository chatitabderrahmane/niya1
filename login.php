<?php
session_start();
include('connection.php');
$_SESSION['incorrect'] = false;

if( isset($_POST['email']) AND isset($_POST['pass']) ){
    
    $email = $_POST['email'];
    $pass = $_POST['pass'];
	
    $rs = $con->prepare("select * from user where email= ? and pass = ?");
    $rs->execute([$email,$pass]);
    
    if($row = $rs->fetch()){
        if($email == $row['email'] AND $pass == $row['pass']){ 
                $_SESSION['email'] = $email;
                $_SESSION['pass'] = $pass;
                header('Location:player_home.php');
				exit();
        }

    }
	// else{
    //     // echo '<script>alert("Incorrect email or password");</script>';
    //     $_SESSION['incorrect'] = true;  
    // }

	$rs = $con->prepare("select * from club where email= ? and pass = ?");
    $rs->execute([$email,$pass]);
    
    if($row = $rs->fetch()){
        if($email == $row['email'] AND $pass == $row['pass']){ 
                $_SESSION['email'] = $email;
                $_SESSION['pass'] = $pass;
                header('Location:club_home.php');
				exit();
        }

    }
	$_SESSION['incorrect'] = true;

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="Logger/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="Logger/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="Logger/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="Logger/vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="Logger/vendor/animsition/css/animsition.min.css">

	<link rel="stylesheet" type="text/css" href="Logger/vendor/select2/select2.min.css">
	
	<link rel="stylesheet" type="text/css" href="Logger/vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="Logger/css/util.css">
	<link rel="stylesheet" type="text/css" href="Logger/css/main.css">

</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form p-l-55 p-r-55 p-t-178" action="login.php" method="post">
					<span class="login100-form-title">
						Sign In
					</span>
                    <?php 

                        if( isset($_SESSION['Exists']) &&  $_SESSION['Exists']){
                            echo "<div class='alert alert-danger' role='alert'> Email already exists </div>";
                        }

						if( isset($_SESSION['incorrect']) &&  $_SESSION['incorrect']){
                            echo "<div class='alert alert-danger' role='alert'> Incorrect email or password </div>";
                        }
                        
                        if( isset($_SESSION['Created']) &&  $_SESSION['Created']){
                            echo "<div class='alert alert-success' role='alert'> Account successfully created </div>";
                        }

						if( isset($_SESSION['newpass']) &&  $_SESSION['newpass']){
                            echo "<div class='alert alert-success' role='alert'> A new password has been sent to your email </div>";
                        }

                    ?>
					<div class="wrap-input100 validate-input m-b-16" data-validate="Please enter username">
						<input class="input100" type="email" name="email" placeholder="Email" required>
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Please enter password">
						<input class="input100" type="password" name="pass" placeholder="Password" required>
						<span class="focus-input100"></span>
					</div>

					<div class="text-right p-t-13 p-b-23">
						<span class="txt1">
							  
						</span>

						<a href="forgotpassword.php" class="txt2">
						Forgot  Password? 
						</a>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit">
							Sign in
						</button>
					</div>

					<div class="flex-col-c p-t-170 p-b-40">
						<span class="txt1 p-b-9">
							Don’t have an account?
						</span>

						<a href="insc_choice.php" class="txt3">
							Sign up now
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	<script src="Logger/vendor/jquery/jquery-3.2.1.min.js"></script>

	<script src="Logger/vendor/animsition/js/animsition.min.js"></script>

	<script src="Logger/vendor/bootstrap/js/popper.js"></script>
	<script src="Logger/vendor/bootstrap/js/bootstrap.min.js"></script>

	<script src="Logger/vendor/select2/select2.min.js"></script>

	<script src="Logger/vendor/daterangepicker/moment.min.js"></script>
	<script src="Logger/vendor/daterangepicker/daterangepicker.js"></script>

	<script src="Logger/vendor/countdowntime/countdowntime.js"></script>

	<script src="Logger/js/main.js"></script>

</body>
</html> 

