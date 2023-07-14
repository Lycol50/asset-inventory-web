<?php
include 'config.php';
session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}

if ($_SESSION['account_type'] !== "admin" && $_SESSION['account_type'] !== "superadmin") {
    echo "<script>alert('You do not have permission to access this page.')</script>";
    sleep(2);
    header('Location: assets.php');
}

// show results from database using the url parameter
$result = mysqli_query($mysqli, "SELECT * FROM assets WHERE asset_tag = '".$_GET['asset_tag']."'");
$row = mysqli_fetch_array($result);

// parse update data to mysql
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "UPDATE assets SET brand=?, model=?, serial_number=?, asset_tag=?, asset_type=?, status=?, equipment_name=?, location_asset=?, price_value=?, date_acquired=?, remarks=? WHERE asset_tag=?";

    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("ssssssssssss", $brand, $model, $serial_number, $asset_tag, $asset_type, $status, $equipment_name, $location_asset, $price_value, $date_acquired, $remarks, $asset_tag);

        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $serial_number = $_POST['serial_number'];
        $asset_tag = $_POST['asset_tag'];
        $asset_type = $_POST['asset_type'];
        $status = $_POST['status'];
        $equipment_name = $_POST['equipment_name'];
        $location_asset = $_POST['location_asset'];
        $price_value = $_POST['price_value'];
        $date_acquired = $_POST['date_acquired'];
        $remarks = $_POST['remarks'];

        if ($stmt->execute()) {
            header('Location: assets.php');
            echo "<script>alert('The Asset has been sucessfully updated.')</script>";
        } else {
            header('Location: assets.php');
            echo "<script>alert('Something went wrong. Please try again!')</script>";
        }
    }
    $stmt->close();
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
        <div class="row">
            <div class="col">
                <h1>Update Asset</h1>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="off">
                    <label for="asset_type">Asset Type</label>
                    <select name="asset_type" id="asset_type" class="form-control">
                        <option value="Office Equipment"
                            <?php if ($row['asset_type'] === 'Office Equipment') echo 'selected'; ?>>Office Equipment</option>
                        <option value="Furnitures and Fixtures"
                            <?php if ($row['asset_type'] === 'Furnitures and Fixtures') echo 'selected'; ?>>Furnitures and
                            Fixtures</option>
                        <option value="Aircon Equipment"
                            <?php if ($row['asset_type'] === 'Aircon Equipment') echo 'selected'; ?>>Aircon Equipment</option>
                    </select>
                    <br>
                    <label for="brand">Brand</label>
                    <input type="text" name="brand" id="brand" class="form-control"
                        value="<?php echo $row['brand']; ?>">
                    <br>
                    <label for="model">Model</label>
                    <input type="text" name="model" id="model" class="form-control"
                        value="<?php echo $row['model']; ?>">
                    <br>
                    <label for="serial_number">Serial Number</label>
                    <input type="text" name="serial_number" id="serial_number" class="form-control"
                        value="<?php echo $row['serial_number']; ?>">
                    <br>
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="Available" <?php if ($row['status'] === 'Available') echo 'selected'; ?>>Available
                        </option>
                        <option value="In Use" <?php if ($row['status'] === 'In Use') echo 'selected'; ?>>In Use</option>
                        <option value="For Repair" <?php if ($row['status'] === 'For Repair') echo 'selected'; ?>>For Repair
                        </option>
                        <option value="For Disposal" <?php if ($row['status'] === 'For Disposal') echo 'selected'; ?>>For
                            Disposal</option>
                    </select>
                    <br>
                    <label for="equipment_name">Equipment Name</label>
                    <input type="text" name="equipment_name" id="equipment_name" class="form-control"
                        value="<?php echo $row['equipment_name']; ?>">
                    <br>
                    <label for="location">Location</label>
                    <input type="text" name="location_asset" id="location_asset" class="form-control"
                        value="<?php echo $row['location_asset']; ?>">
                    <br>
                    <label for="price_value">Price Value</label>
                    <input type="text" name="price_value" id="price_value" class="form-control"
                        value="<?php echo $row['price_value']; ?>">
                    <br>
                    <label for="date_acquired">Date Acquired</label>
                    <input type="date" name="date_acquired" id="date_acquired" class="form-control"
                        value="<?php echo $row['date_acquired']; ?>">
                    <br>
                    <label for="remarks">Remarks</label>
                    <input type="text" name="remarks" id="remarks" class="form-control"
                        value="<?php echo $row['remarks']; ?>">
                    <br>
                    <input type="hidden" name="asset_tag" value="<?php echo $row['asset_tag']; ?>"> <!-- Hidden field for asset_tag -->
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="assets.php" class="btn btn-secondary ml-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>