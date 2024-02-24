<?php
require 'connection.php';
session_start();
$_SESSION['Exists'] = false;
$_SESSION['Created'] = false;
$_SESSION['newpass'] = false;

    if( isset($_POST['nom']) AND isset($_POST['prenom']) 
    AND isset($_POST['email']) AND isset($_POST['tel']) AND 
    isset($_POST['pass']) AND isset($_POST['position'])  AND isset($_FILES['image']) ){

        
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $tel = $_POST['tel'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $position = $_POST['position'];

        try{

            $rs = $con->prepare("select * from user where email= ?");
            $rs->execute([$email]);
            
            if($row = $rs->fetch()){
                    $_SESSION['Exists'] = true;
                    header('Location:login.php');
                    exit();
            }
    
        }catch(PDOEXCEPTION $err){
            echo "Failed To Connect. Error " . $err->getMessage();
        }
        
        try{

            $rs = $con->prepare("select * from club where email= ?");
            $rs->execute([$email]);
            
            if($row = $rs->fetch()){
                    $_SESSION['Exists'] = true;
                    header('Location:login.php');
                    exit();
            }
    
        }catch(PDOEXCEPTION $err){
            echo "Failed To Connect. Error " . $err->getMessage();
        }
        

        if($_FILES["image"]["error"] == 4){
            echo "Image  does not exist ";
            exit;
            echo
            "<script> alert('Image Does Not Exist'); </script>"
            ;
          }
          else{
            $fileName = $_FILES["image"]["name"];
            $fileSize = $_FILES["image"]["size"];
            $tmpName = $_FILES["image"]["tmp_name"];
        
            $validImageExtension = ['jpg', 'jpeg', 'png'];
            $imageExtension = explode('.', $fileName);
            $imageExtension = strtolower(end($imageExtension));
            if ( !in_array($imageExtension, $validImageExtension) ){
                echo "<br> Invalid Image Extension. extension should be jpg, jpeg, png <br>";
              echo
              "
              <script>
                alert('Invalid Image Extension. extension should be jpg, jpeg, png');
              </script>
              ";
            }else if($fileSize > 100000000){
                echo "<br> Image Size Is Too Large <br>";
              echo
              "
              <script>
                alert('Image Size Is Too Large');
              </script>
              ";
            }
            else{
              $newImageName = uniqid();
              $newImageName .= '.' . $imageExtension;
        
              move_uploaded_file($tmpName, 'images/' . $newImageName);


            try{

                $rs = $con->prepare("INSERT INTO user ( nom, prenom, email, pass, tel, position, image) VALUES (?, ?, ?, ?, ?, ?, ?  )");
                $rs->execute([$nom, $prenom, $email,  $pass, $tel, $position, $newImageName]);
        
                if($rs != 0 ){
                    $_SESSION['Created'] = true;
                    header('Location:login.php');
                    
                }else{
                    echo " <br> Account was not created <br> ";
                }
        
            }
            catch(PDOEXCEPTION $err){
                echo "Failed To Connect. Error " . $err->getMessage();
            }

            //   $query = "INSERT INTO user ( nom, prenom, email, pass, tel, image ) VALUES ('$nom', '$prenom', '$email', '$pass', '$tel', '$newImageName')";
            //   mysqli_query($conn, $query);

            //   $_SESSION['Created'] = true;
            //   header('Location:login.php');

            //   echo
            //   "
            //   <script>
            //     alert('Successfully Added');
            //     document.location.href = 'data.php';
            //   </script>
            //   ";
            }
          }


}
  

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Inscription</title>
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

    <style>

        input[type="file"]{
            margin : 0.7rem;
        }

    </style>

</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form p-l-55 p-r-55 p-t-172" method="post" enctype="multipart/form-data">
					<span class="login100-form-title">
						Player Sign Up
					</span>

					<div class="wrap-input100 validate-input m-b-14" data-validate="Please enter username">
						<input class="input100" type="text" name="nom" placeholder="Nom">
						<span class="focus-input100"></span>
					</div>

                    <div class="wrap-input100 validate-input m-b-14" data-validate="Please enter username">
						<input class="input100" type="text" name="prenom" placeholder="Prenom">
						<span class="focus-input100"></span>
					</div>

                    <div class="wrap-input100 validate-input m-b-14" data-validate="Please enter username">
						<input class="input100" type="email" name="email" placeholder="Email">
						<span class="focus-input100"></span>
					</div>

                    <div class="wrap-input100 validate-input m-b-14" data-validate="Please enter username">
						<input class="input100" type="number" name="tel" placeholder="Telephone">
						<span class="focus-input100"></span>
					</div>

                    <div class="wrap-input100 validate-input m-b-14" data-validate="Please enter username">
						<input class="input100" type="text" name="position" placeholder="Position">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-14" data-validate = "Please enter password">
						<input class="input100" type="password" name="pass" placeholder="Mot de passe">
						<span class="focus-input100"></span>
					</div>


                    <div class="wrap-input100 validate-input m-b-18" data-validate="Please select a file">
                        <div>
                            <input class="input-file" type="file" name="image" id="image" accept=".jpg, .jpeg, .png" value="">
                        </div>
                        <span class="focus-input100"></span>
                    </div>

					<!-- <div class="text-right p-t-13 p-b-23">
						<span class="txt1">
							
						</span>

						<a href="#" class="txt2">
							
						</a>
					</div> -->

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit">
							Sign Up
						</button>
					</div>

					<div class="flex-col-c p-t-170 p-b-40">
						<span class="txt1 p-b-9">
							have an account?
						</span>

						<a href="login.php" class="txt3">
							Sign in now
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