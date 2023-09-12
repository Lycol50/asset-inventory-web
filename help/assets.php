<?php
include dirname(__FILE__, 2) . '/config.php';

session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: dirname(__FILE__, 2) . 'login.php'");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CCF Alabang Inventory System (Live Prod) - Help</title>
    <link rel="stylesheet" href="../style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <link rel="icon" type="image/x-icon" href="https://events.ccf.org.ph/assets/app/ccf-logos/ccf-logo-full-white-logo-size.png">
    <link href="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.css" rel="stylesheet">
    <script src="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.22.1/dist/extensions/print/bootstrap-table-print.min.js"></script>
</head>

<body>
    <?php include 'nav.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Assets Overview</h1>
                <p>Here you will see the list of your assets, as well edit and delete.</p>
                <br>
                <p>Clicking the <b>List Assets</b> above of Navigation bar, it will go to the List Assets Page</p>
                <img class="img-fluid" src="imgs/5.png"><br>
                <br>
                <h3>Search Bar</h3>
                <p>Perform Search on any assets</p>
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">Limitations of Searching</h4>
                    <p>You can search anything of your assets, <b>except:</b></p>
                    <hr>
                    <ul>
                        <li>Date Acquired</li>
                        <li>Price Value</li>
                        <li>Documents</li>
                    </ul>
                </div>
                <h3>Sort by Asset Type</h3>
                <p>Here you can perform sorting based on the following Asset Types:</p>
                <ul>
                    <li>Office Equipment</li>
                    <li>Furnitures and Fixtures</li>
                    <li>Aircon Equipment</li>
                </ul>
                <h3>Assets Details</h3>
                <p>Here you can see the details of your assets, as well as edit and delete per asset data.</p>
                <img class="img-fluid" src="imgs/6.png"><br><br>
                <h3>Print Everything</h3>
                <p>Here you can print the assets data.</p>
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">Printing of Assets</h4>
                    <p>When you perform search and/or sort, it will only print on what on the displayed data</p>
                    <p>Example: 
                        <ul>
                            <li>When you search for <b>Chair</b>, it will only print the <b>Chair</b> assets</li>
                            <li>When you sort by <b>Office Equipment</b>, it will only print the <b>Office Equipment</b> assets</li>
                        </ul>
                    </p>
                    <hr>
                    <p>When you want to print all the assets, you must clear the search bar and set sort asset type to <b>All</b></p>
                </div>
                <h3>Add Asset</h3>
                <p>Here you can add new asset data.</p>
            </div>
        </div>
    </div>
</body>