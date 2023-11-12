<?php

include('config/config.php');

$d1 = $_POST['d1'];
$d2 = $_POST['d2'];

$sql = mysqli_query($conn, "SELECT * FROM appointment INNER JOIN owner ON appointment.owner_id = owner.owner_id INNER JOIN petinformation ON appointment.pet_id = petinformation.id WHERE appointment.Status='DONE' AND appointment.appointment_date BETWEEN '$d1' AND '$d2'");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print</title>
</head>
<style>
    table,
    tr,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
        padding: 10px;
    }

    th {
        font-family: serif;
        font-weight: bolder;
        font-size: 20px;
    }

    td {
        width: 100px;
    }
</style>

<body onload="window.print();">
    <center>

        <table id="example9" class="table table-bordered table-hover table-striped list-table">
            <center>
                <h1>Header</h1>
            </center>
            <thead>
                <tr>
                    <th>Owner</th>
                    <th>Pet</th>
                    <th>Service</th>
                    <th>Appointment Scheduled</th>
                    <th>Status</th>
                    <th>Remarks</th>
                    <th>Date Created</th>
                    <!-- <th>Actions</th> -->
                </tr>
            </thead>
            <tbody>
                <?php while ($appointment = mysqli_fetch_array($sql)) { ?>
                    <tr>
                        <td><?php echo $appointment['first_name'] . ' ' . $appointment['last_name']; ?></td>
                        <td><?php echo $appointment['pet_name']; ?></td>
                        <td><?php echo $appointment['service_name']; ?></td>
                        <td>
                            <?php echo date('F d, Y', strtotime($appointment['appointment_date'])) . ' ' . $appointment['appointment_time']; ?>
                        </td>
                        <td><?php echo $appointment['status']; ?></td>
                        <td><?php echo $appointment['remarks']; ?></td>
                        <td><?php echo date('F d, Y', strtotime($appointment['transaction_date'])); ?></td>
                    </tr>
                <?php } ?>

            </tbody>
            <input type="hidden" name="d1" value="<?php echo $d1; ?>">
            <input type="hidden" name="d2" value="<?php echo $d2; ?>">
            <button type="submit" name="submit" class="btn btn-outline-primary hidden-print">Print</button>

        </table>
    </center>
</body>

</html>