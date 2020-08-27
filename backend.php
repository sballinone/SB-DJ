<?php

session_start();

if ($_SESSION['backend'] != true) {
    session_destroy();
    header("Location: login.php");
    exit;
}

include("config.php");
include("multilanguage.php");

include("CMsg.php");
include("CSong.php");

include("functions.php");

$status = new CMsg();
$latestwish;
$latest;

$db = new mysqli($dbhost, $dbuser, $dbpass, $dbbase, $dbport);

if ($db->connect_errno) {
    die("Sorry, I could not connect to the database. Please check your configuration. <br /><br />".$db->connect_error);
}

require_once "action.php";

// Workaround
include("lang/".$_SESSION['lang'].".php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>SB DJ</title>
    <link rel="stylesheet" href="./assets/css/fonts.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="external/flexboxgrid.min.css" type="text/css">
    <link rel="stylesheet" href="external/icofont/icofont.min.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>



<div id="ciHeader">
	<div class="row">
		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
			<div class="box" id="logo">
				<img src="./assets/img/logo/white/Logo-Square-White.png" alt="World of SB">
				DJ
				<span style="color: #ff8a00">2020</span>
				<span style="color: #666666">· <?=$event;?></span>
			</div>
		</div>
		<div class="col-xs-2 col-sm-4 col-md-5 col-lg-5">
			<div class="box">
				&nbsp;
			</div>
		</div>
		<div class="col-xs-2 col-sm-1 col-md-1 col-lg-1">
            <div class="box logout" onclick="javascript:location.href='backend.php?do=export'">
                <a href="backend.php?do=export"><i class="icofont-external"></i></a>
            </div>
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
                <a href='backend.php' class='btnRefresh'><i class="icofont-refresh"></i>&nbsp;<small><?=$output['refresh']; ?></small></a>
                <a href='backend.php?do=resetwishlist' class='btnDanger'><i class="icofont-ui-rate-remove"></i></a>
                <a href='backend.php?do=reset' class='btnDanger'><i class="icofont-database-remove"></i></a>
                <a href='setlist.php' class='btnDefault'><i class='icofont-disc'></i>&nbsp;<small><?=$output['setlist']; ?></small></a>
                <a href='backend.php?do=export' class='btnDefault'><i class="icofont-external-link"></i>&nbsp;<small><?=$output['export']; ?></small></a>
                <a href='backend.php?do=import' class='btnDefault'><i class="icofont-file-sql"></i>&nbsp;<small><?=$output['import']; ?></small></a>
                <a href='qrcode.php' class='btnDefault' target='_blank'><i class="icofont-qr-code"></i>&nbsp;<small><?=$output['qrflyer']; ?></small></i></a>
                <a href='setup.php' class='btnDefault'><i class="icofont-settings-alt"></i></a>
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

                <h2><?=$output['playlist']; ?></h2>
                
                <div class="newitem">
                    <form action="backend.php?do=add" method="Post">
                        <div class="item">
                            <div class="row">
                                <div class="col-xs-2 col-sm-2 col-md-2 col-xl-2">
                                    <div class="box">
                                        &nbsp;
                                    </div>
                                </div>
                                <div class="col-xs-5 col-sm-5 col-md-5 col-xl-5">
                                    <div class="box">
                                        <input type="text" placeholder="<?=$output['title']; ?>" name="title" class="formText" autofocus>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-xl-4">
                                    <div class="box">
                                        <input type="text" placeholder="<?=$output['artist']; ?>" name="artist" class="formText">
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
                setlist($db, 1);
                playlist($db, true, $latest);
                ?>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="box content">
                <h2><?=$output['wishlist']; ?></h2>

                <div class="newitem">
                    <form action="backend.php?do=addwish" method="Post">
                        <div class="item">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-xl-6">
                                    <div class="box">
                                        <input type="text" placeholder="<?=$output['title']; ?>" name="title" class="formText">
                                    </div>
                                </div>
                                <div class="col-xs-5 col-sm-5 col-md-5 col-xl-5">
                                    <div class="box">
                                        <input type="text" placeholder="<?=$output['artist']; ?>" name="artist" class="formText">
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
                wishlist($db, $latestwish);
                ?>
            </div>
        </div>
    </div>

<?php 
include("footer.php"); 
echo "</div>";
?>

</body>
</html>    

<?php
$db->close();
?>