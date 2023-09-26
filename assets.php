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
    <title>CCF Alabang Inventory System (Live Prod)</title>
    <link rel="stylesheet" href="style.css?v=1.1">
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
    <script>
    function confirmAction() {
        return confirm("Are you sure?");
    }
    </script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata">
</head>

<body>
    <?php include 'nav.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Assets</h1>
                <input type="text" id="searchInput" class="form-control form-control-lg d-print-none"
                    placeholder="Search for an asset...">
                <br>
                <select id="assetStatus" class="form-select form-select d-print-none">
                    <option value="">All</option>
                    <option value="Operational">Operational</option>
                    <option value="Idle">Idle</option>
                    <option value="For repair">For Repair</option>
                    <option value="For disposal">For Disposal</option>
                </select>
                <br>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered border-start" id="assetsTable"
                        data-show-print="true">
                        <thead>
                            <tr>
                                <th class="d-print-none">Updated</th>
                                <th>Inventory Checked and Date</th>
                                <th>Tag Number</th>
                                <th>Status</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Asset Type</th>
                                <th>Serial Number</th>
                                <th>Number of Units</th>
                                <th>Asset Cost</th>
                                <th>Level</th>
                                <th>Location</th>
                                <th>Remarks</th>
                                <th>Date Placed</th>
                                <th class="d-print-none actions">Physical Proof</th>
                                <?php if ($_SESSION['account_type'] === "admin" || $_SESSION['account_type'] === "superadmin") {
                                    echo '<th class="d-print-none actions">Actions</th>';
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
                                $param = $row["physical_proof"];
                                $array = explode(",", $param);
                                if (!empty($param)) {
                                    echo "<tr>";
                                        if ($row['updated'] === "1") {
                                            echo "<td style='font-family: consolas; color: green; font-weight: bold'>Yes</td>";
                                        } else {
                                            echo "<td style='font-family: consolas; color: red; font-weight: bold'>No</td>";
                                        }
                                        if ($row['inv_check'] === "1") {
                                            echo "<td style='font-family: consolas, Inconsolata; color: green; font-weight: bold'>Yes " . $row['inv_check_date'] . "</td>";
                                        } else {
                                            echo "<td style='font-family: consolas, Inconsolata; color: red; font-weight: bold'>No</td>";
                                        }
                                    echo "<td style='font-family: consolas, Inconsolata'>" . $row["asset_tag_number"] . "</td>
                                        <td>" . $row["status"] . "</td>
                                        <td>" . $row["category"] . "</td>
                                        <td>" . $row["description"] . "</td>
                                        <td>" . $row["asset_type"] . "</td>
                                        <td>" . $row["serial_number"] . "</td>
                                        <td>" . $row["number_of_units"] . "</td>
                                        <td> ₱" . number_format($row["asset_cost"], 2) . "</td>
                                        <td>" . $row["level"] . "</td>
                                        <td>" . $row["location_unit"] . "</td>
                                        <td>" . $row["remarks"] . "</td>
                                        <td>" . $row["date_placed"] . "</td>
                                        <td class='d-print-none actions'>";
                                    foreach ($array as $document) {
                                        echo "<a href='uploads/" . $row['asset_tag_number'] . "/$document' class='btn btn-sm btn-outline-secondary' target='_blank'>$document</a><br>";
                                    }
                                    echo "</td>";
                                    if ($_SESSION['account_type'] === "admin" || $_SESSION['account_type'] === "superadmin") {
                                        echo "<td class='d-print-none actions'>
                                            <a href='update_asset.php?asset_tag=" . $row["asset_tag_number"] . "' class='btn btn-sm btn-outline-secondary'>Edit</a><br>
                                            <a href='delete_asset.php?asset_tag=" . $row["asset_tag_number"] . "' class='btn btn-sm btn-outline-secondary' onclick='return confirmAction();'>Delete</a><br>
                                            </td>
                                        </tr>";
                                    } else {
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr>";
                                        if ($row['updated'] === "1") {
                                            echo "<td style='font-family: consolas, Inconsolata; color: green; font-weight: bold'>Yes</td>";
                                        } else {
                                            echo "<td style='font-family: consolas, Inconsolata; color: red; font-weight: bold'>No</td>";
                                        }
                                        if ($row['inv_check'] === "1") {

                                            echo "<td style='font-family: consolas, Inconsolata; color: green; font-weight: bold'>Yes " . $row['inv_check_date'] . "</td>";
                                        } else {
                                            echo "<td style='font-family: consolas, Inconsolata; color: red; font-weight: bold'>No</td>";
                                        }
                                    echo "<td style='font-family: consolas, Inconsolata'>" . $row["asset_tag_number"] . "</td>
                                    <td>" . $row["status"] . "</td>
                                    <td>" . $row["category"] . "</td>
                                    <td>" . $row["description"] . "</td>
                                    <td>" . $row["asset_type"] . "</td>
                                    <td>" . $row["serial_number"] . "</td>
                                    <td>" . $row["number_of_units"] . "</td>
                                    <td> ₱" . number_format($row["asset_cost"], 2) . "</td>
                                    <td>" . $row["level"] . "</td>
                                    <td>" . $row["location_unit"] . "</td>
                                    <td>" . $row["remarks"] . "</td>
                                    <td>" . $row["date_placed"] . "</td>
                                    <td></td>";
                                        if ($_SESSION['account_type'] === "admin" || $_SESSION['account_type'] === "superadmin") {
                                            echo "<td class='d-print-none actions'>
                                                <a href='update_asset.php?asset_tag=" . $row["asset_tag_number"] . "' class='btn btn-sm btn-outline-secondary'>Edit</a><br>
                                                <a href='delete_asset.php?asset_tag=" . $row["asset_tag_number"] . "' class='btn btn-sm btn-outline-secondary' onclick='return confirmAction();'>Delete</a><br>
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
                <input type="button" onclick="window.location.href='insert_asset.php'"
                    class="d-print-none btn btn-primary" value="Add Asset" />
                <input type="button" onclick="window.location.href='checkinventory.php'"
                    class="d-print-none btn btn-primary" value="Check Inventory" />
            </div>
        </div>
    </div>
    <script>
    var searchInput = document.getElementById('searchInput');
    var assetStatus = document.getElementById('assetStatus');
    var assetsTable = document.getElementById('assetsTable').getElementsByTagName('tbody')[0];

    searchInput.addEventListener('input', function() {
        filterAssets();
    });

    assetStatus.addEventListener('change', function() {
        filterAssets();
    });

    function filterAssets() {
        var query = searchInput.value.toLowerCase();
        var status = assetStatus.value.toLowerCase();

        for (var i = 0; i < assetsTable.rows.length; i++) {
            var row = assetsTable.rows[i];
            var statusCell = row.cells[3].textContent.toLowerCase();
            var display = false;

            if (status === '' || statusCell.indexOf(status) !== -1) {
                // If Status matches or Status filter is empty
                if (query === '') {
                    display = true; // Display the row
                } else {
                    for (var j = 2; j <= 11; j++) {
                        var cell = row.cells[j];
                        var cellText = cell.textContent.toLowerCase();
                        if (cellText.indexOf(query) !== -1) {
                            display = true;
                            break;
                        }
                    }
                }
            }

            if (display) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    }

    // Call filterAssets initially to display all assets
    filterAssets();
    </script>
    <script>
    function printTable() {
        var table = document.getElementById("assetsTable");
        var newWin = window.open("", "_blank");
        var newDoc = newWin.document;
        newDoc.open();
        newDoc.write(
            '<html><head><title>CCF Alabang Inventory List</title></head><style>.body{font-family: sans-serif, Inconsolata; text-align: left;}</style><body>'
        );
        newDoc.write(
            '<style>@media print {.actions{display:none;} body{font-family:sans-serif, Inconsolata; font-size: 12px;} table {width: 100%; font-size: 90%;} th, td {word-break: break-all; max-width: 100%;}}</style><h1>Asset List</h1>'
        );
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