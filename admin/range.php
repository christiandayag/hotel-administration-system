<?php
	include('db_connect.php');
	if(ISSET($_POST['search'])){
		$date1 = date("Y-m-d", strtotime($_POST['date1']));
		$date2 = date("Y-m-d", strtotime($_POST['date2']));
		$i=1;
		$query=mysqli_query($conn, "SELECT * FROM checked WHERE date(`date_updated`) BETWEEN '$date1' AND '$date2'") or die(mysqli_error());
		$row=mysqli_num_rows($query);
		if($row>0){
			while($fetch=mysqli_fetch_array($query)){
?>
	<tr>
		<td><?php echo $i++ ?></td>
		<td><?php echo $fetch['name']?></td>
		<td class="text-center"><?php echo $cat_arr[$room_arr[$fetch['room_id']]['category_id']]['name'] ?></td>
		<td class=""><?php echo $room_arr[$fetch['room_id']]['room'] ?></td>
		
		<td><?php echo $fetch['ref_no']?></td>
		<td><?php echo $fetch['date_in']?></td>
		<td><?php echo $fetch['date_out']?></td>
		<?php if($fetch['status'] == 2): ?>
		<td class="text-center"><span class="badge badge-success">Checked-Out</span></td>
		<?php endif; ?>
	</tr>
<?php
			}
		}else{
			echo'
			<tr>
				<td colspan = "4"><center>Record Not Found</center></td>
			</tr>';
		}
	}else{
		$i=1;
		$query=mysqli_query($conn, "SELECT * FROM `checked`") or die(mysqli_error());
		while($fetch=mysqli_fetch_array($query)){
?>
	<tr>
		<td><?php echo $i++ ?></td>
		<td><?php echo $fetch['name']?></td>
		<td class="text-center"><?php echo $cat_arr[$room_arr[$fetch['room_id']]['category_id']]['name'] ?></td>
		<td class=""><?php echo $room_arr[$fetch['room_id']]['room'] ?></td>
		
		<td><?php echo $fetch['ref_no']?></td>
		<td><?php echo $fetch['date_in']?></td>
		<td><?php echo $fetch['date_out']?></td>
		<?php if($fetch['status'] == 2): ?>
		<td class="text-center"><span class="badge badge-success">Checked-Out</span></td>
		<?php endif; ?>
	</tr>
<?php
		}
	}
?>
