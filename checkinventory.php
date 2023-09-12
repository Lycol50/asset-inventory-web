<?php
include 'config.php';
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

if ($_SESSION['account_type'] !== "admin" && $_SESSION['account_type'] !== "superadmin") {
    header('Location: 404.php');
}

if (isset($_POST['submit'])) {
    $sql = "SELECT * FROM assets";
    $result = mysqli_query($mysqli, $sql);
    
    while ($row = mysqli_fetch_array($result)) {
        $dateandtime = date("Y-m-d H:i:s");

        if (!empty($_POST['checkbox']) && in_array($row['asset_tag_number'], $_POST['checkbox'])) {
            // Use prepared statements to prevent SQL injection
            $stmt = $mysqli->prepare("UPDATE assets SET inv_check = '1', inv_check_date = ? WHERE asset_tag_number = ?");
            $stmt->bind_param("ss", $dateandtime, $row['asset_tag_number']);
            $stmt->execute();
            $stmt->close();
            $update_message = "Inventory check successful.";
        } else {
            // Use prepared statements to prevent SQL injection
            $stmt = $mysqli->prepare("UPDATE assets SET inv_check = '0' WHERE asset_tag_number = ?");
            $stmt->bind_param("s", $row['asset_tag_number']);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Close the database connection
    $mysqli->close();

    header('Location: assets.php');
    exit; // Ensure no further code execution after redirection
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
</head>

<body>
    <?php include 'nav.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Check Inventory</h1>
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
                <?php if (isset($update_message)) { ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $update_message; ?>
                </div>
                <?php } ?>
                <div class="table-responsive">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                        autocomplete="off">
                        <input type="submit" name="submit" value="Submit Check Inventory"
                            class="btn btn-primary d-print-none">
                        <br><br>
                        <table class="table table-striped table-bordered border-start" id="assetsTable"
                            data-show-print="true">
                            <thead>
                                <tr>
                                    <th>Found</th>
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                            $sql = "SELECT * FROM assets";
                            $result = mysqli_query($mysqli, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>";
                                echo "<td><input type='checkbox' name='checkbox[]' value='" . $row['asset_tag_number'] . "'></td>";
                                echo "<td>" . $row['asset_tag_number'] . "</td>";
                                echo "<td>" . $row['status'] . "</td>";
                                echo "<td>" . $row['category'] . "</td>";
                                echo "<td>" . $row['description'] . "</td>";
                                echo "<td>" . $row['asset_type'] . "</td>";
                                echo "<td>" . $row['serial_number'] . "</td>";
                                echo "<td>" . $row['number_of_units'] . "</td>";
                                echo "<td> ₱" . number_format($row["asset_cost"], 2) . "</td>";
                                echo "<td>" . $row['level'] . "</td>";
                                echo "<td>" . $row['location_unit'] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </form>
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
                var statusCell = row.cells[2].textContent.toLowerCase();
                var display = false;

                if (status === '' || statusCell.indexOf(status) !== -1) {
                    // If Status matches or Status filter is empty
                    if (query === '') {
                        display = true; // Display the row
                    } else {
                        for (var j = 1; j <= 10; j++) {
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

</body>

</html>