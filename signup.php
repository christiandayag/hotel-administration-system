
<?php
session_start();
include('admin/db_connect.php');
use PHPMailer\PHPMailer\PHPMailer;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

if(isset($_POST["register"])){
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $contact = $_POST["contact"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    $check_query = mysqli_query($conn, "SELECT * FROM account where email ='$email'");
    $rowCount = mysqli_num_rows($check_query);

    if(!empty($email) && !empty($password)){
        if($rowCount > 0){
            ?>
            <script>
                alert("User with email already exist!");
            </script>
            <?php
        }else{
//            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $full = $firstname." ".$lastname;

            $result = mysqli_query($conn, "INSERT INTO account (`name`,`firstname`, `lastname`, `contact`, `email`, `username`, `password`, `status`) VALUES ('$full','$firstname','$lastname','$contact','$email', '$username','$password', 0)");

            if($result){

                $otp = rand(100000,999999);
                $_SESSION['otp'] = $otp;
                $_SESSION['mail'] = $email;

//                $to = $email;
//                $subject = "OTP Verification";
//                $txt = "Dear user,Your verify OTP code is \n" .$otp;
//                $header="From: mail.verifier2022@gmail.com";

                $message = "your code is " .$otp;
                $subject = "Email verification";
                $recipient = $email;

                if( send_mail($recipient,$subject,$message)){
                    ?>
                    <script>
                        alert("<?php echo "Register Successfully, OTP sent to " . $email ?>");
                        window.location.replace('verification.php');
                    </script>

                    <?php
                }else{
                    ?>
                    <script>
                        alert("<?php echo "Register Failed, Please check your internet or your email address. "?>");
                    </script>
                    <?php
                }
            }
        }
    }
}
function send_mail($recipient,$subject,$message)
{

    $mail = new PHPMailer();
    $mail->IsSMTP();

    $mail->SMTPDebug  = 0;
    $mail->SMTPAuth   = TRUE;
    $mail->SMTPSecure = "tls";
    $mail->Port       = 587;
    $mail->Host       = "smtp.gmail.com";
    //$mail->Host       = "smtp.mail.yahoo.com";
    $mail->Username   = "joselinas.hotel@gmail.com";
    $mail->Password   = "muxziveygsutpefj";

    $mail->IsHTML(true);
    $mail->AddAddress($recipient, "esteemed customer");
    $mail->SetFrom("joselinas.hotel@gmail.com", "Joselina Hotel");
    //$mail->AddReplyTo("reply-to-email", "reply-to-name");
    //$mail->AddCC("cc-recipient-email", "cc-recipient-name");
    $mail->Subject = $subject;
    $content = $message;

    $mail->MsgHTML($content);
    if(!$mail->Send()) {
        //echo "Error while sending Email.";
        //echo "<pre>";
        //var_dump($mail);
        return false;
    } else {
        //echo "Email sent successfully";
        return true;
    }

}

?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
<!------ Include the above in your HEAD tag ---------->

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="style.css">

    <link rel="icon" href="Favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <title>Signup Form</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="#">Signup Form</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="login.php" >Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="signup.php" style="font-weight:bold; color:black; text-decoration:underline">Signup</a>
                </li>
            </ul>

        </div>
    </div>
</nav>

<main class="login-form">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card align-content-center">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form action="#" method="POST" name="register">
                            <div class="form-group row ">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="firstname" placeholder="Firstname" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row">

                                <div class="col-md-12">
                                    <input type="text"  class="form-control" name="lastname"  placeholder="Lastname" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input type="email" class="form-control" name="email" placeholder="Email" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input type="number"  class="form-control" name="contact" placeholder="Contact Number" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input type="text"  class="form-control" name="username" placeholder="Username" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input type="password" class="form-control" name="password" minlength="8" placeholder="Password" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <input type="submit"  value="Register" name="register">
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

</main>
</body>
</html>
