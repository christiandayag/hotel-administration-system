<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Admin | Hotel Joselina</title>


    <meta content="" name="descriptison">
    <meta content="" name="keywords">



    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link rel="stylesheet" href="assets/font-awesome/css/all.min.css">


    <!-- Vendor CSS Files -->
    <link href="admin/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="admin/assets/vendor/icofont/icofont.min.css" rel="stylesheet">
    <link href="admin/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="admin/assets/vendor/venobox/venobox.css" rel="stylesheet">
    <link href="admin/assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="admin/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="admin/assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="admin/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="admin/assets/DataTables/datatables.min.css" rel="stylesheet">


    <!-- Template Main CSS File -->
    <link href="admin/assets/css/style.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="admin/assets/css/jquery-te-1.4.0.css">

    <script src="admin/assets/vendor/jquery/jquery.min.js"></script>
    <script src="admin/assets/DataTables/datatables.min.js"></script>
    <script src="admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="admin/assets/vendor/jquery.easing/jquery.easing.min.js"></script>
    <script src="admin/assets/vendor/php-email-form/validate.js"></script>
    <script src="admin/assets/vendor/venobox/venobox.min.js"></script>
    <script src="admin/assets/vendor/waypoints/jquery.waypoints.min.js"></script>
    <script src="admin/assets/vendor/counterup/counterup.min.js"></script>
    <script src="admin/assets/vendor/owl.carousel/owl.carousel.min.js"></script>
    <script src="admin/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="admin/assets/font-awesome/js/all.min.js"></script>
    <script type="text/javascript" src="admin/assets/js/jquery-te-1.4.0.min.js" charset="utf-8"></script>


    <?php include('admin/db_connect.php'); ?>
<?php
session_start();
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");
$query = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['setting_'.$key] = $value;
		}
?>

</head>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	    /*background: #007bff;*/
	    font-family: monospace;
	}
	main#main{
		width:100%;
		height: calc(100%);
		background:white;
	}
	#login-right{
		position: absolute;
		right:0;
		width:40%;
		height: calc(100%);
		background:white;
		display: flex;
		align-items: center;
	}
	#login-left{
		position: absolute;
		left:0;
		width:60%;
		height: calc(100%);
		background:#00000061;
		display: flex;
		align-items: center;
	}
	#login-right .card{
		margin: auto
	}
	.logo {
	    margin: auto;
	    font-size: 8rem;
	    background: white;
	    padding: .5em 0.8em;
	    border-radius: 50% 50%;
	    color: #000000b3;
	}
	#login-left {
	  background: url(assets/img/<?php echo $_SESSION['setting_cover_img'] ?>);
	  background-repeat: no-repeat;
	  background-size: cover;
	}
	input[type="submit"]{
		width: 300px;
		height: 50px;
		border: 1px solid;
		background: #2691d9;
		border-radius: 25px;
		font-size: 18px;
		color: #e9f4fb;
		font-weight: 700;
		cursor: pointer;
		outline: none;
	}
	input[type="submit"]:hover{
	border-color: #2691d9;
	transition: 5s;
	}
	.signup_link{
		margin: 30px 0 ;
		text-align: center ;
		font-size: 16px;
		color: #666666;
	}
	.signup_link a{
		color: #2691d9;
		text-decoration: none;
	}
	.signup_link a:hover{
		text-decoration: underline;
	}
	h1{
		text-align: center;
		padding: 0 0 20px 0;
		border-bottom: 1px solid silver;
	}
</style>

<body>


  <main id="main" class=" alert-info">
  		<div id="login-left">
  			<!-- == You can logo or image herre == -->
  			<!-- <div class="logo">
  				<i class="fa fa-poll-h"></i>
  			</div> -->
  		</div>
  		<div id="login-right">
  			<div class="card col-md-8">
  				<div class="card-body">
  					<form method="POST">
  						<div class="form-group">
  							<h3>Forgot Password</h3>
  							<p class="alert alert-danger" style="display:none; text-align:justify;" id="error"></p>
  							<p class="alert alert-success" style="display:none; text-align:justify;" id="sucess"></p>
  							<label for="username" class="control-label">Email</label>
  							<input type="email" id="email" name="email" class="form-control">
  						</div>
  						<!--<center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary">Login</button></center></!-->
  						<center><input type="button" class="btn btn-primary btn-lg btn-block"
  							type="button" id="butsave" value="Reset">
  						<div class="signup_link">
  							 <a href="login.php">Login</a>
  					</form>
  				</div>
  			</div>
  		</div>
   

  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>





<script>
$(document).ready(function() {
    $('#butsave').on('click', function() {
        var email = $('#email').val();
          $.ajax({
          url: "resetpassword.php",
          type: "POST",
          data: {
              email: email,     
          },
          cache: false,
          success: function(dataResult){
              var dataResult = JSON.parse(dataResult);
              if(dataResult.statusCode==200){
                  $("#error").hide();
                  $("#success").show();
                  $('#success').html('Your new password has been sent to your email!');   
                  var delayInMilliseconds = 2000; 

                  setTimeout(function() {
                     window.location.href = 'login.php';
                  }, delayInMilliseconds);                     
              }
              else if(dataResult.statusCode==201){
                  $("#butsave").removeAttr("disabled");
                  $("#error").show();
                  $("#success").hide();
                  $('#error').html('Email Address does not exist!');
              }
          }
      });
    });
});
</script>

</body>

</html>
