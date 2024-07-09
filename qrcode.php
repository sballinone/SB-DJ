<?php

session_start();

if (!isset($_SESSION['backend'])) {
    session_destroy();
    echo "Permission denied. Please log in.";
    exit;
}

include("config.php");

// Hide some footer details
$footernav = false;
$showrelease = false;

// Find and encode URL, parse it to the QR Code API
$uri = (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'];
$qrapi = "https://api.qrserver.com/v1/create-qr-code/?size=".$qrcodesize."x".$qrcodesize."&data=";
$qrapi .= urlencode($uri);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?=$event; ?> &middot; SB DJ</title>
    <link rel="stylesheet" href="assets/css/fonts.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="assets/css/qrcode.css" type="text/css">
    <link rel="stylesheet" href="assets/external/flexboxgrid.min.css" type="text/css">
    <link rel="stylesheet" href="assets/icofont/icofont.min.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div id="wrap">
    <?php for ($x = 0; $x < 4; $x++) {?>
        <div class="tile">
            <div class="row">
                <div class="box content">
                    <?php 
                    echo $qrtext;
                    echo "<div class='qrcode'><img src='".$qrapi."'><br />".$uri."</div>";
                    ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>


</body>
</html>    

