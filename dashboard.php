<?php
include 'config.php';

session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Asset Management System</title>
    <link rel="stylesheet" href="style.css?v=1.1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <link rel="icon" type="image/x-icon" href="white.png">
</head>

<body>
    <?php include 'nav.php'; ?>
    <div class="container">
        <h1>Dashboard</h1><br>
        <div class="row row-cols-2 row-cols-md-2">
            <div class="col">
                <div class="card text-white bg-primary mb-3" style="min-height:91%; text-align:center;">
                    <div class="card-header">All Assets</div>
                    <div class="card-body d-flex flex-column">
                        <h3 class="card-title">Primary card title</h3>
                        <h5 class="card-text">All Assets in this building</h5>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-success mb-3" style="min-height:91%; text-align:center;">
                    <div class="card-header">In Use</div>
                    <div class="card-body d-flex flex-column">
                        <h3 class="card-title">Primary card title</h3>
                        <h5 class="card-text">In Use Assets in this building</h5>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-success mb-3" style="min-height:91%; text-align:center;">
                    <div class="card-header">In Storage</div>
                    <div class="card-body d-flex flex-column">
                        <h3 class="card-title">Primary card title</h3>
                        <h5 class="card-text">In Storage Assets in this building</h5>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-success mb-3" style="min-height:91%; text-align:center;">
                    <div class="card-header">For Repair</div>
                    <div class="card-body d-flex flex-column">
                        <h3 class="card-title">Primary card title</h3>
                        <h5 class="card-text">For Repair Assets in this building</h5>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-success mb-3" style="min-height:91%; text-align:center;">
                    <div class="card-header">For Disposal</div>
                    <div class="card-body d-flex flex-column">
                        <h3 class="card-title">Primary card title</h3>
                        <h5 class="card-text">For Disposal Assets in this building</h5>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-success mb-3" style="min-height:91%; text-align:center;">
                    <div class="card-header">Date and Time</div>
                    <div class="card-body d-flex flex-column">
                        <h3 class="card-title"><div id="timeNow"></div></h3>
                        <h5 class="card-text">Today is <?php echo date("l, F j, Y");?></h5>
                    </div>
                </div>
            </div>
        </div>
        <script>
        var d = new Date(<?php date_default_timezone_set('UTC'); echo strtotime('now')*1000 ?>);
        (function foo(){
            d.setTime(d.getTime()+1000);
            var clientTime = d.getHours() + ":"  + d.getMinutes() + ":" + d.getSeconds() + " " + (d.getHours() >= 12 ? 'pm' : 'am');
            //alert(clientTime);
            document.getElementById("timeNow").innerHTML = clientTime;
            setTimeout(foo, 1000); // refresh time every 1 second
        })();
    </script>
</body>

</html>