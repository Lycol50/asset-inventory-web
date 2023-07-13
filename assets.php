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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <!-- create table that showing the list of assets in database -->
    <?php include 'nav.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Assets</h1>
                <!-- serch bar for assets use js for this-->
                <input type="text" id="searchInput" placeholder="Search for an asset...">
                <button id="searchButton">Search</button>
                <script>
                document.getElementById('searchButton').addEventListener('click', function() {
                    var searchQuery = document.getElementById('searchInput').value;
                    searchAssets(searchQuery);
                });

                function searchAssets(query) {
                    var table = document.getElementById('assetsTable');
                    var rows = table.getElementsByTagName('tr');

                    for (var i = 0; i < rows.length; i++) {
                        var assetName1 = rows[i].getElementsByTagName('td')[0];
                        var assetName2 = rows[i].getElementsByTagName('td')[1];
                        var assetName3 = rows[i].getElementsByTagName('td')[2];
                        var assetName4 = rows[i].getElementsByTagName('td')[3];
                        var assetName5 = rows[i].getElementsByTagName('td')[4];
                        var assetName6 = rows[i].getElementsByTagName('td')[5];
                        var assetName7 = rows[i].getElementsByTagName('td')[6];
                        var assetName8 = rows[i].getElementsByTagName('td')[8];
                        if (assetName1 || assetName2 || assetName3 || assetName4 || assetName5 || assetName6 || assetName7 || assetName8) {
                            var name = assetName.textContent || assetName.innerText;
                            if (name.indexOf(query) > -1) {
                                rows[i].style.display = '';
                            } else {
                                rows[i].style.display = 'none';
                            }
                        }
                    }
                }
                </script>
                <br>
                <!-- table for assets -->
                <table class="table table-striped" id="assetsTable">
                    <thead>
                        <tr>
                            <th>Asset Tag</th>
                            <th>Asset Type</th>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Equipment Name</th>
                            <th>Serial Number</th>
                            <th>Status</th>
                            <th>Date Acquired</th>
                            <th>Location</th>
                            <th>Documents</th>
                            <th class="d-print-none">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // include 'config.php';
                        $sql = "SELECT * FROM assets";
                        $result = $mysqli->query($sql);
                        function showdocuments ($param) {
                            $array = explode(",", $param);
                            foreach ($array as $document) {
                                echo "<a href='uploads/$document' class='btn btn-sm btn-outline-secondary target='_blank'>$document</a>&nbsp;";
                            }
                        }
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $documents_row = $row["documents"];
                                echo "<tr>
                                <td style='font-family:consolas'>" . $row["asset_tag"] . "</td>
                                <td>" . $row["asset_type"] . "</td>
                                <td>" . $row["brand"] . "</td>
                                <td>" . $row["model"] . "</td>
                                <td>" . $row["equipment_name"] . "</td>
                                <td>" . $row["serial_number"] . "</td>
                                <td>" . $row["status"] . "</td>
                                <td>" . $row["date_acquired"] . "</td>
                                <td>" . $row["location_asset"] . "</td>
                                <td>";
                                    $param = $row["documents"];
                                    $array = explode(",", $param);
                                    foreach ($array as $document) {
                                        echo "<a href='uploads/$document' class='btn btn-sm btn-outline-secondary' target='_blank'>$document</a><br>";
                                    }
                                echo "</td>
                                <td class='d-print-none'>
                                    <a href='update_asset.php?asset_tag=" . $row["asset_tag"] . "' class='btn btn-sm btn-outline-secondary'>Edit</a><br>
                                    <a href='delete_asset.php?asset_tag=" . $row["asset_tag"] . "' class='btn btn-sm btn-outline-secondary'>Delete</a><br>
                                </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='100%'><center>No Data Avaliable</center></td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <input type="button" onclick="window.print()" value="Print Everything"
                    class="d-print-none btn btn-primary" />
                <a href="insert_asset.php" class="d-print-none btn btn-primary">Add Asset</a>
            </div>
        </div>