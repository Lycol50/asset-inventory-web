<?php
// Retrieve the asset tag numbers from asset.php
$assetTags = []; // Initialize an array to store asset tag numbers

// Fetch asset tag numbers from asset.php
// Modify the code below based on your implementation in asset.php to retrieve the asset tag numbers
// Example: $assetTags = ['ASSET-001', 'ASSET-002', 'ASSET-003'];

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

<body style="text-align:center">
    <div class="container">
        <div class="row">
            <div class="col">
                <img src="logo_info.png" alt="logo" class="logo" width="100px">
                <?php foreach ($assetTags as $assetTag) { ?>
                    <p><?php echo $assetTag; ?></p>
                <?php } ?>
            </div>
        </div>
    </div>
</body>

</html>
