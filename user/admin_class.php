<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
        extract($_POST);
        $qry = $this->db->query("SELECT users.name,users.password,users.username,account.user_id,account.name,account.contact,account.email FROM users inner JOIN account ON users.name=account.name where users.username='$username' and users.password='$password'");
        if($qry->num_rows > 0){
//            foreach ($qry->fetch_array() as $key => $value) {
//                if($key != 'passwors' && !is_numeric($key))
//                    $_SESSION['login_'.$key] = $value;
            $row=mysqli_fetch_assoc($qry);
            $_SESSION["login_name"]=$row['name'];
            $_SESSION["login_email"]=$row['email'];
            $_SESSION["login_contact"]=$row['contact'];
            $_SESSION["login_type"]=$row['type'];
            $_SESSION["login_username"]=$row['username'];
            if($_SESSION['login_type'] == 1)
                return 1;
            else
                return 2;
        }
        else{
            return 3;
        }
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../login.php");
	}

	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		$data .= ", password = '$password' ";
		$data .= ", type = '$type' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}

	function save_settings(){
		extract($_POST);
		$data = " hotel_name = '$name' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '".htmlentities(str_replace("'","&#x2019;",$about))."' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'../assets/img/'. $fname);
					$data .= ", cover_img = '$fname' ";

		}
		
		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set ".$data." where id =".$chk->fetch_array()['id']);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set ".$data);
		}
		if($save){
		$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['setting_'.$key] = $value;
		}

			return 1;
				}
	}

	function save_category(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", price = '$price' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'../assets/img/'. $fname);
					$data .= ", cover_img = '$fname' ";

		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO room_categories set ".$data);
		}else{
			$save = $this->db->query("UPDATE room_categories set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_category(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM room_categories where id = ".$id);
		if($delete)
			return 1;
	}
	function save_room(){
		extract($_POST);
		$data = " room = '$room' ";
		$data .= ", category_id = '$category_id' ";
		$data .= ", status = '$status' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO rooms set ".$data);
		}else{
			$save = $this->db->query("UPDATE rooms set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}

	function delete_room(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM rooms where id = ".$id);
		if($delete)
			return 1;
	}

    function save_check_in(){

        extract($_POST);
        $data = " room_id = '$rid' ";
        $data .= ", name = '$name' ";
        $data .= ", email = '$email' ";
        $data .= ", contact_no = '$contact' ";
        $data .= ", status = 1 ";

        $data .= ", date_in = '".$date_in.' '.$date_in_time."' ";
        $out= date("Y-m-d H:i",strtotime($date_in.' '.$date_in_time.' +'.$days.' days'));
        $data .= ", date_out = '$out' ";
        $i = 1;
        while($i== 1){
            $ref  = sprintf("%'.04d\n",mt_rand(1,9999999999));
            if($this->db->query("SELECT * FROM checked where ref_no ='$ref'")->num_rows <= 0)
                $i=0;
        }
        $data .= ", ref_no = '$ref' ";


        if(empty($id)){

            $save = $this->db->query("INSERT INTO checked set ".$data);
            $id=$this->db->insert_id;

        }else{
            $save = $this->db->query("UPDATE checked set ".$data." where id=".$id);
        }
        if($save){

            $this->db->query("UPDATE rooms set status = 1 where id=".$rid);
            return $id;
        }
    }
	function save_checkout(){
		extract($_POST);
			$save = $this->db->query("UPDATE checked set status = 2 where id=".$id);
			if($save){

				$this->db->query("UPDATE rooms set status = 0 where id=".$rid);
						return 1;
			}

	}
	function save_book(){
		extract($_POST);
		$data = " booked_cid = '$cid' ";
		$data .= ", name = '$name' ";
		$data .= ", contact_no = '$contact' ";
		$data .= ", email= '$email' ";
		$data .= ", status = 0 ";

		$data .= ", date_in = '".$date_in.' '.$date_in_time."' ";
		$out= date("Y-m-d H:i",strtotime($date_in.' '.$date_in_time.' +'.$days.' days'));
		$data .= ", date_out = '$out' ";
		$i = 1;
		while($i== 1){
			$ref  = sprintf("%'.04d\n",mt_rand(1,9999999999));
			if($this->db->query("SELECT * FROM checked where ref_no ='$ref'")->num_rows <= 0)
				$i=0;
		}
		$data .= ", ref_no = '$ref' ";

		$mail = new PHPMailer(true);
        try{
				//Enable verbose debug output
				$mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;

				//Send using SMTP
				$mail->isSMTP();

				//Set the SMTP server to send through
				$mail->Host = 'smtp.gmail.com';

				//Enable SMTP authentication
				$mail->SMTPAuth = true;

				//SMTP username
				$mail->Username = 'christiandaniel.spup@gmail.com';

				//SMTP password
				$mail->Password = 'rzon pkvf grwj xesv';

				//Enable TLS encryption;
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

				//TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
				$mail->Port = 587;

				//Recipients
				$mail->setFrom('christiandaniel.spup@gmail.com');

				//Add a recipient
				$mail->addAddress($email, $name);

				//Set email format to HTML
				$mail->isHTML(true);



				$mail->Subject = 'Email verification';
				$mail->Body    = '<p>You have successfully booked. Thankyou and God Bless!: <b style="font-size: 60px;"></b></p>';

				$mail->send();
				// echo 'Message has been sent';
		}catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}

		$save = $this->db->query("INSERT INTO checked set ".$data);
		$id=$this->db->insert_id;

		if($save){
					return $id;
		}
	}
    function verify_email(){
        extract($_POST);
        $data = " booked_cid = '$cid' ";
        $data .= ", name = '$name' ";
        $data .= ", contact_no = '$contact' ";
        $data .= ", email= '$email' ";
        $data .= ", status = 0 ";

        $data .= ", date_in = '".$date_in.' '.$date_in_time."' ";
        $out= date("Y-m-d H:i",strtotime($date_in.' '.$date_in_time.' +'.$days.' days'));
        $data .= ", date_out = '$out' ";
        $i = 1;
        while($i== 1){
            $ref  = sprintf("%'.04d\n",mt_rand(1,9999999999));
            if($this->db->query("SELECT * FROM checked where ref_no ='$ref'")->num_rows <= 0)
                $i=0;
        }
        $data .= ", ref_no = '$ref' ";

        $mail = new PHPMailer(true);
        try{
            //Enable verbose debug output
            $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;

            //Send using SMTP
            $mail->isSMTP();

            //Set the SMTP server to send through
            $mail->Host = 'smtp.gmail.com';

            //Enable SMTP authentication
            $mail->SMTPAuth = true;

            //SMTP username
            $mail->Username = 'christiandaniel.spup@gmail.com';

            //SMTP password
            $mail->Password = 'rzon pkvf grwj xesv';

            //Enable TLS encryption;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('christiandaniel.spup@gmail.com');

            //Add a recipient
            $mail->addAddress($email, $name);

            //Set email format to HTML
            $mail->isHTML(true);



            $mail->Subject = 'Email verification';
            $mail->Body    = '<p>You have successfully booked. Thankyou and God Bless!: <b style="font-size: 60px;"></b></p>';

            $mail->send();
            // echo 'Message has been sent';
        }catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        $save = $this->db->query("INSERT INTO checked set ".$data);
        $id=$this->db->insert_id;

        if($save){
            return $id;
        }
    }

}