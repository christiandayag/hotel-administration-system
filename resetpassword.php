<?php
	include('admin/db_connect.php');

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	$email = $_POST['email'];
		
	$count = mysqli_query($conn,"SELECT * FROM account WHERE email= '$email' ");
	$rowcheck = mysqli_fetch_array($count);
	$username = $rowcheck['username'];
      
    if(mysqli_num_rows($count) == 0){
        echo json_encode(array("statusCode"=>201));
    }else{

		//sending email
		require 'PHPMailer-master/src/Exception.php';
		require 'PHPMailer-master/src/PHPMailer.php';
		require 'PHPMailer-master/src/SMTP.php';

		$mail = new PHPMailer();
		$mail->IsSMTP();

		$alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$pword = array();
		$alphalen = strlen($alphabet)-1;
		for($i = 0; $i < 4; $i++){
			$n = rand(0, $alphalen);
			$x = rand($alphalen, 0);
			$pword[] = $alphabet[$n];
		}
		$pword = implode($pword);

		$mail->SMTPDebug  = 0;  
		$mail->SMTPAuth   = TRUE;
		$mail->SMTPSecure = "tls";
		$mail->Port       = 587;
		$mail->Host       = "smtp.gmail.com";
		$mail->Username   = "joselinas.hotel@gmail.com";
		$mail->Password   = "lmuvkhriodfqkkrs";

		$mail->IsHTML(true);
		$mail->AddAddress($email, "Reset Password");
		$mail->SetFrom("joselinas.hotel@gmail.com", "Joselina Hotel");
		$mail->Subject = 'Reset Password';
		$content = 'Your password has been successfully reset. Here is your new password: '.'<b>'. $pword.'</b>';

		$mail->MsgHTML($content); 

		if(!$mail->Send()) {
		    return false;
		}else{
		   $sql = mysqli_query($conn, "UPDATE account SET password='$pword' WHERE email='$email'");
		   $sql = mysqli_query($conn, "UPDATE users SET password='$pword' WHERE username='$username'");
			if($sql){
            	echo json_encode(array("statusCode"=>200));
      		}else{
            	echo json_encode(array("statusCode"=>202));
      		}

		   return true;
		 }
		
	}

?>