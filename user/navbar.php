<!--<<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<script src="https://kit.fontawesome.com/21c6a13fcf.js" crossorigin="anonymous"></script>
</head>
<style>
	nav#sidebar {
    background: url(../assets/img/<?php echo $_SESSION['setting_cover_img'] ?>);
    background-repeat: no-repeat;
    background-size: cover;
</style>
<body>
<nav id="sidebar" class='mx-lt-5' >

		<div class="sidebar-list">

				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Home</a>
				<a href="index.php?page=booked" class="nav-item nav-booked"><span class='icon-field'><i class="fa fa-book"></i></span> Booked </a>
				<a href="index.php?page=check_in" class="nav-item nav-check_in"><span class='icon-field'><i class="fa fa-sign-in-alt"></i></span> Check In </a>
				<a href="index.php?page=check_out" class="nav-item nav-check_out"><span class='icon-field'><i class="fa fa-sign-out-alt"></i></span> Check Out </a>
				<a href="index.php?page=categories" class="nav-item nav-categories"><span class='icon-field'><i class="fa fa-list"></i></span> Add Room</a>
				<a href="index.php?page=rooms" class="nav-item nav-rooms"><span class='icon-field'><i class="fa fa-bed"></i></span> Rooms </a>
				<?php if($_SESSION['login_type'] == 1): ?>
				<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>
				<a href="index.php?page=site_settings" class="nav-item nav-site_settings"><span class='icon-field'><i class="fa fa-cogs"></i></span> Settings</a>
			<?php endif; ?>
		</div>

</nav>
</body>
</html>-->



<DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>ASC yMandaya Hotel</title>
		<script src="https://kit.fontawesome.com/21c6a13fcf.js" crossorigin="anonymous"></script>
	</head>
<style>
	nav#sidebar {
    background: url(../assets/img/<?php echo $_SESSION['setting_cover_img'] ?>);
    background-repeat: no-repeat;
    background-size: cover;
</style>
<nav id="sidebar" class='mx-lt-5' >

		<div class="sidebar-list">

				
<!--				<a href="index.php?page=available" class="nav-item nav-booked"><span class='icon-field'><i class="fa fa-book"></i></span> Available </a>-->
<!--				<a href="index.php?page=home" class="nav-item nav-check_in"><span class='icon-field'><i class="fa-solid fa-bars"></i></span> Dashboard</a>-->
				<a href="index.php?page=check_in" class="nav-item nav-check_in"><span class='icon-field'><i class="fa-solid fa-check-to-slot"></i></span> Room Category </a>
				<a href="index.php?page=reservation" class="nav-item nav-check_in"><span class='icon-field'><i class="fa-solid fa-check-to-slot"></i></span> Reserved </a>
            <a href="index.php?page=booked" class="nav-item nav-check_out"><span class='icon-field'><i class="fa fa-sign-out-alt"></i></span> Booked </a>
				<a href="index.php?page=check_out" class="nav-item nav-check_out"><span class='icon-field'><i class="fa fa-sign-out-alt"></i></span> Check Out </a>

            <?php if($_SESSION['login_type'] == 1): ?>
				<a href="index.php?page=categories" class="nav-item nav-categories"><span class='icon-field'><i class="fa-solid fa-plus"></i></span> Add Room</a>
				<a href="index.php?page=rooms" class="nav-item nav-rooms"><span class='icon-field'><i class="fa fa-bed"></i></span>List of Rooms </a>
				<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa-solid fa-user-tie"></i></span> Users</a>
				<a href="index.php?page=site_settings" class="nav-item nav-site_settings"><span class='icon-field'><i class="fa-solid fa-sliders"></i></span> Settings</a>
			<?php endif; ?>
		</div>

</nav>
</html>
<script>
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>