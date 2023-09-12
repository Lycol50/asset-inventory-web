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

$asset_tag = $_GET['asset_tag'];
$asset_tag_number = $_GET['asset_tag'];

// prepare sql statement
$query = "SELECT * FROM assets WHERE asset_tag_number = ?";
if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param("s", $_GET['asset_tag']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
}

// validate asset to if no cents
if (strpos($row['asset_cost'], '.') !== false) {
    $row['asset_cost'] = substr($row['asset_cost'], 0, strpos($row['asset_cost'], '.'));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "UPDATE assets SET level = ?, location_unit = ?, description = ?, serial_number = ?, number_of_units = ?, asset_cost = ?, status = ?, updated = ?, remarks = ? WHERE asset_tag_number = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        // bind variables to the prepared statement as parameters
        $stmt->bind_param("sssssssiss", $param_level, $param_location, $param_description, $param_serial_number, $param_number_of_units, $param_asset_cost, $param_status, $param_updated, $param_remarks, $param_asset_tag_number);
        
        // set parameters
        $param_level = $_POST['level'];
        $param_location = $_POST['location'];
        $param_description = $_POST['description'];
        $param_serial_number = $_POST['serial_number'];
        $param_number_of_units = $_POST['number_of_units'];
        $param_asset_cost = $_POST['asset_cost'];
        $param_status = $_POST['status'];
        $param_asset_tag_number = $_POST['asset_tag_number'];
        $param_remarks = $_POST['remarks'];
        $param_updated = "1";
        
        // attempt to execute the prepared statement
        if ($stmt->execute()) {
            header('Location: assets.php');
            echo "<script>alert('The Asset has been successfully updated.')</script>";
        } else {
            $warning = "Oops! Something went wrong. Please try again later: " . $stmt->error; // Add error message
        }
    } else {
        $warning = "Oops! Something went wrong. Please try again later: " . $mysqli->error; // Add error message
    }
    $stmt->close(); // Close the statement
}

// define variables and set to empty values
$level_err = $location_err = $description_err = $serial_number_err = $number_of_units_err = $asset_cost_err = $status_err = "";

// define variables and set to empty values
$level = $location = $description = $serial_number = $number_of_units = $asset_cost = $status = "";

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
</head>

<body>
    <?php include 'nav.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Update Asset for Asset Tag: <?php echo $asset_tag; ?></h1>

                <?php

                if (!empty($warning)) {
                    echo '<div class="alert alert-danger">' . $warning . '</div>';
                }

                ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="off"
                    enctype='multipart/form-data'>
                    <label for="status">Status</label>
                    <select name="status" id="status"
                        class="form-control <?php echo (!empty($status_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $status; ?>">
                        <option value="Operational" <?php if ($row['status'] === 'Operational') echo 'selected'; ?>>
                            Operational</option>
                        <option value="Idle" <?php if ($row['status'] === 'Idle') echo 'selected'; ?>>Idle</option>
                        <option value="For repair" <?php if ($row['status'] === 'For repair') echo 'selected'; ?>>For
                            Repair</option>
                        <option value="For disposal" <?php if ($row['status'] === 'For disposal') echo 'selected'; ?>>
                            For Disposal</option>
                    </select>
                    <span class="invalid-feedback"><?php echo $status_err; ?></span>
                    <br>
                    <label for="category">Category</label>
                    <select name="category" id="category"
                        class="form-control <?php echo (!empty($category_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $category; ?>">
                        <option value="AUDIO_AND_SOUND_5_YEARS"
                            <?php if ($row['status'] === 'AUDIO_AND_SOUND_5_YEARS') echo 'selected'; ?>>Audio and Sound
                            - 5 Years</option>
                        <option value="AUDIO_AND_SOUND_3_YEARS"
                            <?php if ($row['status'] === 'AUDIO_AND_SOUND_3_YEARS') echo 'selected'; ?>>Audio and Sound
                            - 3 Years</option>
                        <option value="VIDEO_TV_AND_CAMERA_5_YEARS"
                            <?php if ($row['status'] === 'VIDEO_TV_AND_CAMERA_5_YEARS') echo 'selected'; ?>>Video TV and
                            Camera - 5 Years</option>
                        <option value="VIDEO_TV_AND_CAMERA_3_YEARS"
                            <?php if ($row['status'] === 'VIDEO_TV_AND_CAMERA_3_YEARS') echo 'selected'; ?>>Video TV and
                            Camera - 3 Years</option>
                        <option value="LIGHTING_THEATRICAL_5_YEARS"
                            <?php if ($row['status'] === 'LIGHTING_THEATRICAL_5_YEARS') echo 'selected'; ?>>Lighting
                            Theatrical - 5 Years</option>
                        <option value="LIGHTING_THEATRICAL_3_YEARS"
                            <?php if ($row['status'] === 'LIGHTING_THEATRICAL_3_YEARS') echo 'selected'; ?>>Lighting
                            Theatrical - 3 Years</option>
                        <option value="AUDIO_VIDEO_ACCESSORY_5_YEARS"
                            <?php if ($row['status'] === 'AUDIO_VIDEO_ACCESSORY_5_YEARS') echo 'selected'; ?>>
                            Audio-Video Accessories - 5 Years</option>
                        <option value="AUDIO_VIDEO_ACCESSORY_3_YEARS"
                            <?php if ($row['status'] === 'AUDIO_VIDEO_ACCESSORY_3_YEARS') echo 'selected'; ?>>
                            Audio-Video Accessories - 3 Years</option>
                        <option value="COMPUTER_PERIPHERAL_5_YEARS"
                            <?php if ($row['status'] === 'COMPUTER_PERIPHERAL_5_YEARS') echo 'selected'; ?>>Computer
                            Peripheral - 5 Years</option>
                        <option value="COMPUTER_PERIPHERAL_3_YEARS"
                            <?php if ($row['status'] === 'COMPUTER_PERIPHERAL_3_YEARS') echo 'selected'; ?>>Computer
                            Peripheral - 3 Years</option>
                        <option value="DESKTOP_5_YEARS"
                            <?php if ($row['status'] === 'DESKTOP_5_YEARS') echo 'selected'; ?>>Desktop - 5 Years
                        </option>.
                        <option value="DESKTOP_3_YEARS"
                            <?php if ($row['status'] === 'DESKTOP_3_YEARS') echo 'selected'; ?>>Desktop - 3 Years
                        </option>
                        <option value="LAPTOP_5_YEARS"
                            <?php if ($row['status'] === 'LAPTOP_5_YEARS') echo 'selected'; ?>>Laptop - 5 Years</option>
                        <option value="LAPTOP_3_YEARS"
                            <?php if ($row['status'] === 'LAPTOP_3_YEARS') echo 'selected'; ?>>Laptop - 3 Years</option>
                        <option value="COMMUNICATIONS_5_YEARS"
                            <?php if ($row['status'] === 'COMMUNICATIONS_5_YEARS') echo 'selected'; ?>>Communications -
                            5 Year</option>
                        <option value="COMMUNICATIONS_3_YEARS"
                            <?php if ($row['status'] === 'COMMUNICATIONS_3_YEARS') echo 'selected'; ?>>Communications -
                            3 Year</option>
                        <option value="OTHER_EQUIP_AND_SUPP_5_YEARS"
                            <?php if ($row['status'] === 'OTHER_EQUIP_AND_SUPP_5_YEARS') echo 'selected'; ?>>Other
                            Equipment and Supplies- 5 Year</option>
                        <option value="OTHER_EQUIP_AND_SUPP_3_YEARS"
                            <?php if ($row['status'] === 'OTHER_EQUIP_AND_SUPP_3_YEARS') echo 'selected'; ?>>Other
                            Equipment and Supplies- 3 Year</option>
                    </select>
                    <span class="invalid-feedback"><?php echo $category_err; ?></span>
                    <br>
                    <label for="description">Description</label>
                    <input type="text" name="description" id="description"
                        class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo htmlspecialchars($row['description']); ?>">
                    <span class="invalid-feedback"><?php echo $description_err; ?></span>
                    <br>
                    <label for="asset_type">Asset Type</label>
                    <input type="text" name="asset_type" id="asset_type"
                        class="form-control <?php echo (!empty($assettype_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo htmlspecialchars($row['asset_type']); ?>">
                    <span class="invalid-feedback"><?php echo $assettype_err; ?></span>
                    <br>
                    <label for="serial_number">Serial Number</label>
                    <input type="text" name="serial_number" id="serial_number"
                        class="form-control <?php echo (!empty($serial_number_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo htmlspecialchars($row['serial_number']); ?>">
                    <span class="invalid-feedback"><?php echo $serial_number_err; ?></span>
                    <br>
                    <label for="number_of_units">Number of Units</label>
                    <input type="number" name="number_of_units" id="number_of_units"
                        class="form-control <?php echo (!empty($number_of_units_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo htmlspecialchars($row['number_of_units']); ?>">
                    <span class="invalid-feedback"><?php echo $number_of_units_err; ?></span>
                    <br>
                    <label for="asset_cost">Asset Cost</label>
                    <input type="number" step="0.01" name="asset_cost" id="asset_cost"
                        class="form-control <?php echo (!empty($asset_cost_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo htmlspecialchars($row['asset_cost']); ?>">
                    <span class="invalid-feedback"><?php echo $asset_cost_err; ?></span>
                    <br>
                    <label for="level">Level</label>
                    <input type="text" name="level" id="level"
                        class="form-control <?php echo (!empty($level_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo htmlspecialchars($row['level']); ?>">
                    <span class="invalid-feedback"><?php echo $level_err; ?></span>
                    <br>
                    <label for="location">Location</label>
                    <input type="text" name="location" id="location"
                        class="form-control <?php echo (!empty($location_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo htmlspecialchars($row['location_unit']); ?>">
                    <span class="invalid-feedback"><?php echo $location_err; ?></span>
                    <br>
                    <label for="remarks">Remarks</label>
                    <input type="text" name="remarks" id="remarks"
                        class="form-control <?php echo (!empty($remarks_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo htmlspecialchars($row['remarks']); ?>">
                    <br>
                    <input type="hidden" name="asset_tag_number" value="<?php echo $asset_tag ?>">
                    <input type="submit" name="update" class="btn btn-primary" value="Update"
                        onClick="return confirm('Confirm to Update this Asset?')">
                    <a href="dashboard.php" class="btn btn-secondary ml-2"
                        onClick="return confirm('Do you want to go back? All inserted data here before submitting will be gone!')">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>