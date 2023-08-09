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
    <title>Asset Management System</title>
    <link rel="stylesheet" href="../style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <link rel="icon" type="image/x-icon" href="white.png">
    <link href="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.css" rel="stylesheet">
    <script src="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.22.1/dist/extensions/print/bootstrap-table-print.min.js"></script>
</head>

<body>
    <?php include 'nav.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Adding Asset</h1>
                <p>Here you will see how to add an asset.</p>
                <br>
                <p>Clicking the <b>Insert Asset</b> above of Navigation bar or Clicking <b>Add Asset</b> on List Assets
                    Page, it will go to the Insert Assets Page</p>
                <img class="img-fluid" src="imgs/7.png"><br>
                <br>
                <h3>Inserting the New Asset into the System</h3>
                <ol>
                    <li>Select the <b>Asset Type</b> first</li>
                    <li>Insert the Name of the <b>Brand</b> of the Asset</li>
                    <li>Insert the <b>Model</b> of the Asset</li>
                    <li>Insert the <b>Serial Number</b> of the Asset</li>
                    <li>Select the <b>Status</b> of the Asset</li>
                    <li>Insert the <b>Equipment Name</b> of the Asset, usually it is a whole name of the asset</li>
                    <li>Insert the <b>Location</b> of the Asset</li>
                    <li>Insert he <b>Price Value</b> of the Asset</li>
                    <li>Select the <b>Date</b> it was acquired/purchased</li>
                    <li>Upload the documents of that asset, it may be a receipt, purchase order, and so on.
                        <div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading">Supported Document Types</h4>
                            <p>You can upload one or more documents, but there are file limitations, listed below:</p>
                            <hr>
                            <p>jpg, jpeg, png, pdf, docx</p>
                        </div>
                    </li>
                    <li>Insert any Remarks for that Asset</li>
                    <li>Click the <b>Submit</b> button to insert the asset into the system</li>
                    <li>And a popup will appear that the Asset has been inserted successfully, and number of files uploaded.</li>
                    <li>Clicking <b>Cancel</b> will go back to dashboard and will erase any data inserted before submitting</li>
                </ol>
            </div>
        </div>
    </div>
</body>