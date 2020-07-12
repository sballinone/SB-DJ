<?php

session_start();

if($_SESSION['backend'] != true) {
    session_destroy();
    header("Location: login.php");
    exit;
}

include("config.php");
include("CMsg.php");
include("CSong.php");

include("functions.php");

$status = new CMsg();

$db = new mysqli($dbhost, $dbuser, $dbpass, $dbbase, $dbport);

if($db->connect_errno) {
    die("Sorry, I could not connect to the database. Please check your configuration. <br /><br />".$db->connect_error);
}

require_once "action.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>SB DJ</title>
    <link rel="stylesheet" href="css/fonts.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/flexboxgrid.min.css" type="text/css">
    <link rel="stylesheet" href="icofont/icofont.min.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div id="wrap">
    <div class="row" id="header">
        <div class="box">
            <h1>SB DJ</h1>
            <span class="event"><?=$event;?>
            <a href='backend.php'><i class="icofont-refresh"></i> Refresh</a>
            <a href='backend.php?do=resetwishlist'><i class="icofont-ui-rate-remove"></i></a>
            <a href='backend.php?do=reset'><i class="icofont-database-remove"></i></a>
            <a href='backend.php?do=export'><i class="icofont-external-link"></i></a>
            <a href='login.php'><i class="icofont-logout"></i></a>
            
            <div id="msg">
                <?=$status->printMsg();?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="box">
                <h2>Playlist</h2>
                <div class="newitem">
                    <form action="backend.php?do=add" method="Post">
                        <input type="text" placeholder="Title" name="title">
                        <input type="text" placeholder="Artist" name="artist">
                        <input type="submit" value="Add">
                    </form>
                </div>

                <?php
                playlist($db);
                ?>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="box">
                <h2>Wishlist</h2>
                <div class="newitem">
                    <form action="backend.php?do=addwish" method="Post">
                        <input type="text" placeholder="Title" name="title">
                        <input type="text" placeholder="Artist" name="artist">
                        <input type="submit" value="Add">
                    </form>
                </div>

                <?php
                wishlist($db);
                ?>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>

</body>
</html>    

<?php
$db->close();
?>
