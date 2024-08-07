<?php

session_start();

if (!isset($_SESSION['backend'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

include("config.php");
include("inc/localization.php");

include("class/CMsg.php");
include("class/CSong.php");

include("inc/functions.php");

$status = new CMsg();
$latestwish = "";

$db = new mysqli($dbhost, $dbuser, $dbpass, $dbbase, $dbport);

if ($db->connect_errno) {
    die("Sorry, I could not connect to the database. Please check your configuration. <br /><br />".$db->connect_error);
}

require_once "inc/action.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>SB DJ</title>
    <link rel="stylesheet" href="assets/css/fonts.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="assets/external/flexboxgrid.min.css" type="text/css">
    <link rel="stylesheet" href="assets/external/icofont/icofont.min.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>



<div id="ciHeader">
	<div class="row">
		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
			<div class="box" id="logo">
				<img src="assets/img/Logo-Square-White.png" alt="World of SB">
				DJ
				<span style="color: #ff8a00">2024</span>
				<span style="color: #666666">· <?=$event;?></span>
			</div>
		</div>
		<div class="col-xs-2 col-sm-4 col-md-5 col-lg-5">
			<div class="box">
				&nbsp;
			</div>
		</div>
		<div class="col-xs-2 col-sm-1 col-md-1 col-lg-1">
            &nbsp;
		</div>
		<div class="col-xs-2 col-sm-1 col-md-1 col-lg-1">
            <div class="box logout" onclick="javascript:location.href='index.php'">
                <a href='index.php'><i class="icofont-music-notes"></i></a>
            </div>
		</div>
		<div class="col-xs-2 col-sm-1 col-md-1 col-lg-1">
			<div class="box" id="tripSum" onclick="javascript:location.href='backend.php'">
				<i class='icofont-refresh'></i>
			</div>
		</div>
	</div>
</div>


<div id="wrap">
    <div class="row" id="header">
        <div class="box">

            <div class="btn">
                <a href='backend.php' class='btnRefresh'><i class="icofont-play-pause"></i> <small><?=_("Back"); ?></small></a>
                <a href='setlist.php?do=resetsetlist' class='btnDanger'><i class="icofont-ui-delete"></i></a>
                <a href='login.php' class='btnDefault'><i class="icofont-logout"></i></a>
            </div>

            <div id="msg">
                <?=$status->printMsg(); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="box content">

                <h2><?=_("Setlist"); ?></h2>
                
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
                                        <input type="text" placeholder="<?=_("Title"); ?>" name="title" class="formText">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-xl-6">
                                    <div class="box">
                                        <input type="text" placeholder="<?=_("Artist"); ?>" name="artist" class="formText">
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

        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="box content">

                <h2><?=_("Wishlist"); ?></h2>

                <?php
                wishlist($db, 0);
                ?>

            </div>
        </div>
    </div>

<?php 
include("inc/footer.php");
echo "</div>";
?>

</body>
</html>    

<?php
$db->close();
?>
