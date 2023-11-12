<?php include('db_connect.php');

if (isset($_POST['save'])){
    $cid=$_POST['c_name'];
    $user=$_POST['user_name'];
    $contact=$_POST['contact'];
    $email=$_POST['email'];

    $insert = mysqli_query($conn,"INSERT INTO `reservation` (`name_reservor`, `contact`, `email`, `category`, `status`) VALUES ('$user', '$contact', '$email', '$cid', 'reserved')");
    if ($insert == true){
        echo'<script>alert("Reservation Successful, please approach the information desk that you have a reservation.");window.open("index.php?page=reservation","_self")</script>';
    }else{
        echo'<script>alert("Error Reservation.");window.open("index.php?page=reservation","_self")</script>';
    }
}
?>
<div class="container-fluid">

		<div class="row mt-2">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<table class="table table-bordered text-center table-striped">

							<thead>
								<th>#</th>
								<th>Category</th>
								<th>Action</th>
							</thead>
							<tbody>
								<?php
								$i = 1;
                                $select=mysqli_query($conn,"Select * from room_categories");
                                $select_user= mysqli_query($conn,"select * from account where name = '".$_SESSION['login_name']."'");
                                if (mysqli_num_rows($select_user)>0){
                                    $row_u=mysqli_fetch_assoc($select_user);
                                }
                                if (mysqli_num_rows($select) > 0){
                                    while ($row=mysqli_fetch_assoc($select)){
								?>
								<tr>
                                    <form action="" method="post">
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="text-center"><?php echo $row['name'] ?></td>
                                    <input type="hidden"value="<?php echo $row['id']?>" name="c_name">
                                    <input type="hidden"value="<?php echo $row_u['name']?>" name="user_name">
                                    <input type="hidden"value="<?php echo $row_u['contact']?>" name="contact">
                                    <input type="hidden"value="<?php echo $row_u['email']?>" name="email">

									<td class="text-center">
                                        <button type="submit" class="btn btn-outline-primary" name="save">Reserve</button>
									</td>
                                    </form>
								</tr>
							<?php
                                }
                            }
                            ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$('table').dataTable()
	// $('.check_in').click(function(){
	// 	uni_modal("Check In","manage_check_in.php?rid="+$(this).attr("data-id"))
	// })
	// $('#filter').submit(function(e){
	// 	e.preventDefault()
	// 	location.replace('index.php?page=check_in&category_id='+$(this).find('[name="category_id"]').val()+'&status='+$(this).find('[name="status"]').val())
	// })
</script>