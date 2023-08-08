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
    <link href="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.css" rel="stylesheet">
    <script src="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.22.1/dist/extensions/print/bootstrap-table-print.min.js"></script>
</head>

<body>
    <?php include 'nav.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Assets</h1>
                <input type="text" id="searchInput" class="form-control form-control-lg d-print-none"
                    placeholder="Search for an asset..."><br>
                <select id="assetType" class="form-select form-select d-print-none">
                    <option value="">All</option>
                    <option value="Office Equipment">Office Equipment</option>
                    <option value="Furnitures and Fixtures">Furnitures and Fixtures</option>
                    <option value="Aircon Equipment">Aircon Equipment</option>
                </select>
                <script>
                var searchInput = document.getElementById('searchInput');
                var assetType = document.getElementById('assetType');

                searchInput.addEventListener('input', function() {
                    var searchQuery = searchInput.value;
                    var selectedAssetType = assetType.value;
                    searchAssets(searchQuery, selectedAssetType);
                });

                assetType.addEventListener('change', function() {
                    var searchQuery = searchInput.value;
                    var selectedAssetType = assetType.value;
                    searchAssets(searchQuery, selectedAssetType);
                });

                function searchAssets(query, assetType) {
                    var table = document.getElementById('assetsTable');
                    var rows = table.getElementsByTagName('tr');

                    for (var i = 1; i < rows.length; i++) {
                        var found = false;
                        var cells = rows[i].getElementsByTagName('td');

                        for (var j = 0; j < cells.length; j++) {
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
                <div class="table-responsive">
                    <table class="table table-striped table-bordered border-start" id="assetsTable"
                        data-show-print="true">
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
                                <th>Price Value</th>
                                <th>Location</th>
                                <th>Remarks</th>
                                <th>Date Updated and User</th>
                                <th>Documents</th>
                                <?php if ($_SESSION['account_type'] === "admin" || $_SESSION['account_type'] === "superadmin") {
                                    echo "<th class='d-print-none'>Actions</th>";
                                } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        $sql = "SELECT * FROM assets";
                        $result = $mysqli->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $sql2 = "SELECT * FROM users WHERE user_id = '" . $row["user_id"] . "'";
                                $result2 = $mysqli->query($sql2);
                                $row2 = $result2->fetch_assoc();
                                $param = $row["documents"];
                                $array = explode(",", $param);
                                if (!empty($param)) {
                                    echo "<tr>
                                        <td style='font-family: consolas'>" . $row["asset_tag"] . "</td>
                                        <td>" . $row["asset_type"] . "</td>
                                        <td>" . $row["brand"] . "</td>
                                        <td>" . $row["model"] . "</td>
                                        <td>" . $row["equipment_name"] . "</td>
                                        <td>" . $row["serial_number"] . "</td>
                                        <td>" . $row["status"] . "</td>
                                        <td>" . $row["date_acquired"] . "</td>
                                        <td> ₱" . number_format(intval($row["price_value"]), 2) . "</td>
                                        <td>" . $row["location_asset"] . "</td>
                                        <td>" . $row["remarks"] . "</td>
                                        <td>" . $row["updated_at"] . " by " . $row2["firstname"] . "</td>;
                                        <td>";
                                    foreach ($array as $document) {
                                        echo "<a href='uploads/$document' class='btn btn-sm btn-outline-secondary' target='_blank'>$document</a><br>";
                                    }
                                    echo "</td>";
                                    if ($_SESSION['account_type'] === "admin" || $_SESSION['account_type'] === "superadmin") {
                                        echo "<td class='d-print-none actions'>
                                            <a href='update_asset.php?asset_tag=" . $row["asset_tag"] . "' class='btn btn-sm btn-outline-secondary'>Edit</a><br>
                                            <a href='delete_asset.php?asset_tag=" . $row["asset_tag"] . "' class='btn btn-sm btn-outline-secondary' onClick='return confirm('Delete This Asset Data?')'>Delete</a><br>
                                        </td>
                                        </tr>";
                                    } else {
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr>
                                        <td style='font-family: consolas'>" . $row["asset_tag"] . "</td>
                                        <td>" . $row["asset_type"] . "</td>
                                        <td>" . $row["brand"] . "</td>
                                        <td>" . $row["model"] . "</td>
                                        <td>" . $row["equipment_name"] . "</td>
                                        <td>" . $row["serial_number"] . "</td>
                                        <td>" . $row["status"] . "</td>
                                        <td>" . $row["date_acquired"] . "</td>
                                        <td> ₱" . number_format(intval($row["price_value"]), 2) . "</td>
                                        <td>" . $row["location_asset"] . "</td>
                                        <td>" . $row["remarks"] . "</td>
                                        <td>" . $row["updated_at"] . " by " . $row2["firstname"] . "</td>
                                        <td></td>";
                                        if ($_SESSION['account_type'] === "admin" || $_SESSION['account_type'] === "superadmin") {
                                            echo "<td class='d-print-none actions'>
                                                <a href='update_asset.php?asset_tag=" . $row["asset_tag"] . "' class='btn btn-sm btn-outline-secondary'>Edit</a><br>
                                                <a href='delete_asset.php?asset_tag=" . $row["asset_tag"] . "' class='btn btn-sm btn-outline-secondary' onClick='return confirm('Delete This Asset Data?')'>Delete</a><br>
                                            </td>
                                            </tr>";
                                        } else {
                                            echo "</tr>";
                                        }
                                }
                            }
                        } else {
                            echo "<tr><td colspan='100%'><center>No Data Available</center></td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <input type="button" onclick="printTable()" value="Print Everything"
                    class="d-print-none btn btn-primary" />
                <a href="insert_asset.php" class="d-print-none btn btn-primary">Add Asset</a>
            </div>
        </div>
    </div>
    <script>
    function printTable() {
        var table = document.getElementById("assetsTable");
        var newWin = window.open("", "_blank");
        var newDoc = newWin.document;
        newDoc.open();
        newDoc.write('<html><head><title>Print</title></head><style>.body{font-family: sans-serif;}</style><body>');
        newDoc.write('<style>@media print{.actions{display:none;} body{font-family:sans-serif;}}</style><h1>Asset List</h1>');
        newDoc.write(table.outerHTML);
        newDoc.write('</body></html>');
        newDoc.close();
        newWin.onafterprint = function() {
            newWin.close();
        };
        newWin.print();
    }
    </script>
</body>

</html>