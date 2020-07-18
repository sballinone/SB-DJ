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
$latestwish;

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
    <link rel="stylesheet" href="external/flexboxgrid.min.css" type="text/css">
    <link rel="stylesheet" href="external/icofont/icofont.min.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div id="wrap">
    <div class="row" id="header">
        <div class="box">
            <h1><?=$event;?></h1>

            <div class="btn">
                <a href='backend.php' class='btnRefresh'><i class="icofont-play-pause"></i> <small>Back</small></a>
                <a href='setlist.php?do=resetsetlist' class='btnDanger'><i class="icofont-ui-delete"></i></a>
                <a href='login.php' class='btnDefault'><i class="icofont-logout"></i></a>
            </div>

            <div id="msg">
                <?=$status->printMsg();?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
            <div class="box content">

                <h2>Setlist</h2>
                
                <div class="newitem">
                    <form action="setlist.php?do=addsetlist" method="Post">
                        <div class="item">
                            <div class="row">
                                <div class="col-xs-1 col-sm-1 col-md-1 col-xl-1">
                                    <div class="box">
                                        &nbsp;
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-xl-4">
                                    <div class="box">
                                        <input type="text" placeholder="Title" name="title" class="formText">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-xl-4">
                                    <div class="box">
                                        <input type="text" placeholder="Artist" name="artist" class="formText">
                                    </div>
                                </div>
                                <div class="col-xs-2 col-sm-2 col-md-2 col-xl-2">
                                    <div class="box">
                                        &nbsp;
                                    </div>
                                </div>
                                <div class="col-xs-1 col-sm-1 col-md-1 col-xl-1">
                                    <div class="box">
                                        <div class="actions">
                                            <input type="submit" value="+" class="formSubmit">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <?php
                setlist($db);
                ?>
            </div>
        </div>

        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="box content">

                <h2>Playlist</h2>

                <?php
                playlist($db,false);
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
