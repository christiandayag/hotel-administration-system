<?php include('db_connect.php'); ?>
<div class="container-fluid">
	<div class="col-lg-12">
		
		<div class="row mt-3">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<table class="table table-bordered text-center table-striped">
							<thead>
								<th>#</th>
								<th>Date Filed</th>
								<th>Category</th>
								<th>Status</th>
								<th>Action</th>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$select_res = mysqli_query($conn,"Select * from reservation where status='reserved'");
								if (mysqli_num_rows($select_res) > 0){
								    while ($row=mysqli_fetch_assoc($select_res)){
								        ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td class="text-center"><?php echo $row['date_reserved']?></td>
                                    <td class="text-center">
                                        <?php
                                        $select_cat=mysqli_query($conn,"select * from room_categories where id='".$row['category']."'");
                                        if (mysqli_num_rows($select_cat) > 0){
                                            $r=mysqli_fetch_assoc($select_cat);
                                            echo $r['name'];
                                        }
                                       ?>
                                    </td>
                                    <td class="text-center ">
                                        <?php
                                        if ($row['status'] == "reserved"){
                                            echo '<span class="badge bg-primary text-light">'.$row['status'].'</span>';
                                        }elseif ($row['status'] == "check in"){
                                            echo '<span class="badge bg-success text-light">'.$row['status'].'</span>';
                                        }elseif ($row['status'] == "check out"){
                                            echo '<span class="badge bg-success text-light">'.$row['status'].'</span>';
                                        }
                                        else{
                                            echo '<span class="badge bg-danger text-light">'.$row['status'].'</span>';
                                        }
                                        ?></td>
                                    <td class="text-center">
                                        <?php
                                        if ($row['status'] == "canceled" or $row['status'] == "check out"){?>
                                            <a href="delete_reservation.php?id=<?php echo $row['reserve_id'] ?>" class="btn btn-sm btn-outline-danger btn-sm" >Delete</a>
                                        <?php }
                                        elseif ($row['status'] == "reserved"){
                                            ?>
                                            <a href="cancel_reservation.php?id=<?php echo $row['reserve_id'] ?>" class="btn btn-sm btn-outline-danger btn-sm" >Cancel</a>
                                            <?php
                                        }elseif ($row['status'] == "check in"){
                                            ?>
                                            <a href="cancel_reservation.php?id=<?php echo $row['reserve_id'] ?>" class="btn btn-sm btn-outline-danger btn-sm" >Cancel</a>
                                        <?php } else{
                                            ?>
                                            <a href="cancel_reservation.php?id=<?php echo $row['reserve_id'] ?>" class="btn btn-sm btn-outline-danger btn-sm" >Cancel</a>
                                            <?php
                                        }
                                        ?>
                                    </td>
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
	$('.check_in').click(function(){
		uni_modal("Check In","manage_check_in.php?rid="+$(this).attr("data-id"))
	})
	$('#filter').submit(function(e){
		e.preventDefault()
		location.replace('index.php?page=check_in&category_id='+$(this).find('[name="category_id"]').val()+'&status='+$(this).find('[name="status"]').val())
	})
</script>