<style>
    .custom-menu {
        z-index: 1000;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid #0000001c;
        border-radius: 5px;
        padding: 8px;
        min-width: 13vw;
    }
    a.custom-menu-list {
        width: 100%;
        display: flex;
        color: #4c4b4b;
        font-weight: 600;
        font-size: 1em;
        padding: 1px 11px;
    }
    span.card-icon {
        position: absolute;
        font-size: 3em;
        bottom: .2em;
        color: #20c997;
    }
    .file-item{
        cursor: pointer;
    }
    a.custom-menu-list:hover,.file-item:hover,.file-item.active {
        background: #80808024;
    }
    table th,td{
        /*border-left:1px solid gray;*/
    }
    a.custom-menu-list span.icon{
        width:1em;
        margin-right: 5px
    }
    .candidate {
        margin: auto;
        width: 23vw;
        padding: 0 10px;
        border-radius: 20px;
        margin-bottom: 1em;
        display: flex;
        border: 3px solid #00000008;
        background: #8080801a;

    }
    .candidate_name {
        margin: 8px;
        margin-left: 3.4em;
        margin-right: 3em;
        width: 100%;
    }
    .img-field {
        display: flex;
        height: 8vh;
        width: 4.3vw;
        padding: .3em;
        background: #80808047;
        border-radius: 50%;
        position: absolute;
        left: -.7em;
        top: -.7em;
    }

    .candidate img {
        height: 100%;
        width: 100%;
        margin: auto;
        border-radius: 50%;
    }
    .vote-field {
        position: absolute;
        right: 0;
        bottom: -.4em;
    }

</style>
<?php include "db_connect.php"?>
<main role="main" class="container m-3 p-4 mb-0">
    <div class="card">
        <div class="card-body">
            <div class="col-md-12  align-content-center">
                <div class="row">
                    <div class="col-md-4 mb-4 ">
                        <div class="card card-tale bg-danger">
                            <div class="card-body text-black">
                                <?php
                                $reserve=mysqli_query($conn,"select count(*) as reserve from reservation where status='reserved'");
                                if (mysqli_num_rows($reserve)>0){
                                    $row=mysqli_fetch_assoc($reserve);
                                }
                                ?>
                                <h4><b>Reservation</b></h4>
                                <hr>
                                <span class="card-icon"><i class="fa fa-sticky-note"></i></span>
                                <h3 class="text-right mx-6"><b><?=$row['reserve']?></b></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4 ">
                        <div class="card card-dark-blue bg-success">
                            <div class="card-body text-black">
                                <?php
                                $room=mysqli_query($conn,"select count(*) as room from rooms ");
                                if (mysqli_num_rows($room)>0){
                                    $row=mysqli_fetch_assoc($room);
                                }
                                ?>
                                <h4><b>Rooms</b></h4>
                                <hr>
                                <span class="card-icon"><i class="fa fa-home"></i></span>
                                <h3 class="text-right "><b><?=$row['room']?></b></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4 mb-lg-0 ">
                        <div class="card card-light-blue bg-warning">
                            <div class="card-body text-black">
                                <?php
                                $r=mysqli_query($conn,"select count(*)as total from rooms where status='1'");
                                if (mysqli_num_rows($r)>0){
                                    $row=mysqli_fetch_assoc($r);
                                }
                                ?>
                                <h4><b>Occupied Room</b></h4>
                                <hr>
                                <span class="card-icon"><i class="fa fa-calendar-check"></i></span>
                                <h3 class="text-right mr-2"><b><?=$row['total']?></b></h3>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="container">
                <div class="card ">
                    <div class="card-body ">
                        <h5 class="card-title">Weekly Booked History</h5>
                        <!-- Line Chart -->
                        <canvas id="lineChart"  style="max-height: 400px;"></canvas>
                    </div>
                </div>
            </div>
      <?php
                $sql=mysqli_query($conn,"SELECT room_categories.*,rooms.*,checked.*,room_categories.name as cat_name from checked inner join rooms on checked.room_id=rooms.id inner join room_categories on rooms.category_id=room_categories.id order by date_in ASC");
                if (mysqli_num_rows($sql)>0){
                    $date_in=array();
                    $status=array();
                    while ($row=mysqli_fetch_assoc($sql)){
                        $date_in[]=$row['date_in'];
                        $status[]=$row['status'];
                    }
                }
                ?>
            </div>
        </div>
    </div>
    </div>

</main>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.1/dist/Chart.min.js"></script>

<script>
    const date_in = <?php echo json_encode($date_in)?>;
    const status = <?php echo json_encode($status)?>;
    document.addEventListener("DOMContentLoaded", () => {
        new Chart(document.querySelector('#lineChart'), {
            type: 'line',
            data: {
                labels: date_in,
                datasets: [{
                    label: 'Booked Report',
                    data: status,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
<!-- End Line Chart -->
