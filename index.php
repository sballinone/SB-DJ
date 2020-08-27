<?php

session_start();

if (!file_exists("config.php")) {
    header("Location: setup.php");
    exit;
}

include("config.php");
include("multilanguage.php");

include("CMsg.php");
include("CSong.php");

include("functions.php");

$status = new CMsg();
$latestwish;

$db = new mysqli($dbhost, $dbuser, $dbpass, $dbbase, $dbport);

if ($db->connect_errno) {
    die("Sorry, I could not connect to the database. Please contact the service staff. <br /><br />".$db->connect_error);
}

require_once "action.php";

// Workaround
include("lang/".$_SESSION['lang'].".php");
?>

<!DOCTYPE html>
<html>
<head>
    <title><?=$event; ?> &middot; SB DJ</title>
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
			<?php if($export) { ?>
				<div class="box logout" onclick="javascript:location.href='index.php?do=export'">
					<a href="index.php?do=export"><i class="icofont-external"></i></a>
				</div>
			<?php } ?>
		</div>
		<div class="col-xs-2 col-sm-1 col-md-1 col-lg-1">
			<?php if($footernav) { ?>
				<div class="box logout" onclick="javascript:location.href='backend.php'">
					<a href='backend.php'><i class="icofont-retro-music-disk"></i></a>
				</div>
			<?php } ?>
		</div>
		<div class="col-xs-2 col-sm-1 col-md-1 col-lg-1">
			<div class="box" id="tripSum" onclick="javascript:location.href='index.php'">
				<i class='icofont-refresh'></i>
			</div>
		</div>
	</div>
</div>

<div id="wrap">
    <div class="row" id="header">
        <div class="box">

            <div id="btn">
                <a href='index.php' class='btnRefresh'><i class="icofont-refresh"></i>&nbsp;<small><?=$output['refresh']; ?></small></a>
                <a href='#playlist' class='btnDefault'><i class="icofont-sound-wave"></i>&nbsp;<small><?=$output['playlist']; ?></small></a>
                <?php
                if ($export) { 
                    echo "<a href='index.php?do=export' class='btnDefault'><i class='icofont-external-link'></i>&nbsp;<small>".$output['export']."</small></a>";
                }
                ?>
            </div>
            
            <div id="msg">
                <?=$status->printMsg(); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="box content">
                <h2><?=$output['wishlist']; ?></h2>
                
                <div class="newitem">
                    <form action="index.php?do=addwish" method="Post">
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

        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="box content">
                <h2><?=$output['playlist']; ?><a name="playlist" style="visibility: hidden"></a></h2>

                <?php
                playlist($db);
                ?>
            </div>
        </div>
    </div>

<?php 

include("footer.php"); 

echo "</div>";

if (!strip_tags($_COOKIE['allowCookies']) && $cookieconsent) {
    echo '<div id="cookieconsent" class="latestwish">'.$output["cookieconsent"].' <a href="index.php?do=allowcookies">'.$output["allow"].'</a></div>';
    echo "<style>#wrap { position: fixed; }</style>";
}
?>

</body>
</html>    

<?php
$db->close();
?>