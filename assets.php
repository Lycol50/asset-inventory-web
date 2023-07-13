<?php
include 'config.php';

session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission
    $selectedAssets = $_POST['selectedAssets'];
    
    // Redirect to the print page with the selected asset tags
    header('Location: print_assets.php?selectedAssets=' . urlencode(implode(',', $selectedAssets)));
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
                <input type="text" id="searchInput" class="form-control form-control-lg d-print-none"
                    placeholder="Search for an asset..."><br>
                <!-- insert dropdown for asset type and use the js below for sorting -->
                <select id="assetType" class="form-select form-select d-print-none">
                    <option value="">All</option>
                    <option value="Office Equipment">Office Equipment</option>
                    <option value="Furnitures and Fixtures">Furnitures and Fixtures</option>
                    <option value="Aircon Equipment">Aircon Equipment</option>
                </select>
                <script>
                // Get references to the input field and asset type dropdown
                var searchInput = document.getElementById('searchInput');
                var assetType = document.getElementById('assetType');

                // Add an input event listener to the search input
                searchInput.addEventListener('input', function() {
                    var searchQuery = searchInput.value;
                    var selectedAssetType = assetType.value;
                    searchAssets(searchQuery, selectedAssetType);
                });

                // Add a change event listener to the asset type dropdown
                assetType.addEventListener('change', function() {
                    var searchQuery = searchInput.value;
                    var selectedAssetType = assetType.value;
                    searchAssets(searchQuery, selectedAssetType);
                });

                // Function to search assets
                function searchAssets(query, assetType) {
                    var table = document.getElementById('assetsTable');
                    var rows = table.getElementsByTagName('tr');

                    for (var i = 1; i < rows.length; i++) {
                        var found = false;
                        var cells = rows[i].getElementsByTagName('td');

                        for (var j = 0; j < cells.length; j++) {
                            // Check only the specified columns (0, 1, 2, 3, 4, 5, 6, and 8)
                            if ([0, 1, 2, 3, 4, 5, 6, 8].includes(j)) {
                                var name = cells[j].textContent || cells[j].innerText;
                                if ((name.toLowerCase().indexOf(query.toLowerCase()) > -1) &&
                                    (assetType === '' || assetType === cells[1].textContent)) {
                                    found = true;
                                    break;
                                }
                            }
                        }

                        if (found) {
                            rows[i].style.display = '';
                        } else {
                            rows[i].style.display = 'none';
                        }
                    }
                }
                </script>
                <br>
                <!-- table for assets -->
                <form method="POST" action="">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered border-start" id="assetsTable">
                            <thead>
                                <tr>
                                    <th>Select</th>
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
                                function showdocuments($param)
                                {
                                    $array = explode(",", $param);
                                    foreach ($array as $document) {
                                        echo "<a href='uploads/$document' class='btn btn-sm btn-outline-secondary target='_blank'>$document</a>&nbsp;";
                                    }
                                }
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $documents_row = $row["documents"];
                                        echo "<tr>
                                            <td>
                                                <input type='checkbox' name='selectedAssets[]' value='" . $row["asset_tag"] . "'>
                                            </td>
                                            <td style='font-family:'Consolas','Courier New', monospac'>" . $row["asset_tag"] . "</td>
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
                        <input type="submit" name="printAssets" value="Print Selected for Asset Tag" class="d-print-none btn btn-primary" />
                        <input type="button" onclick="window.print()" value="Print Asset Data" class="d-print-none btn btn-primary" />
                        <a href="insert_asset.php" class="d-print-none btn btn-primary">Add Asset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
