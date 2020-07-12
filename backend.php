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

<html>
<head>
    <title>SB DJ</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="icofont/icofont.min.css" type="text/css">
</head>
<body>

<div id="wrap">
    <div id="header">
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

    <div id="col1">
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

    <div id="col2">
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

<?php include("footer.php"); ?>

</body>
</html>    

<?php
$db->close();
?>
