<?php
$release = "2020.1.0";

session_start();

if($_SESSION['backend'] != true) {
    if(file_exists("config.php")) {
        session_destroy();
        header("Location: login.php");
        exit;
    }
}

include("multilanguage.php");

include("CMsg.php");
$status = new CMsg();

$dbstatus = "Default";


// Save config
if(isset($_GET['do'])) {
    $_SESSION['backend'] = true;

    $pwd = strip_tags($_POST['pwd']);
    $event = strip_tags($_POST['event']);
    $qrtext = strip_tags($_POST['qrtext'],"<h3></h3><br><br /><p></p>");
    $qrcodesize = strip_tags($_POST['qrcodesize']);
    $dbhost = strip_tags($_POST['dbhost']);
    $dbuser = strip_tags($_POST['dbuser']);
    $dbpass = strip_tags($_POST['dbpass']);
    $dbbase = strip_tags($_POST['dbbase']);
    $dbport = strip_tags($_POST['dbport']);
    $defaultLang = strip_tags($_POST['defaultLang']);
    $showlang = strip_tags($_POST['showlang']);
    $footernav = strip_tags($_POST['footernav']);
    $credits = strip_tags($_POST['credits']);
    $showrelease = strip_tags($_POST['showrelease']);
    $export = strip_tags($_POST['export']);
    $cookieconsent = strip_tags($_POST['cookieconsent']);

    $file=fopen("config.php","w");
    fwrite($file,"<?php ". PHP_EOL);
    fwrite($file,"// Automatically created by SB DJ ". PHP_EOL);
    fwrite($file,"// ".date('d.m.Y H:i'). PHP_EOL);
    fwrite($file,"\$pwd = '".$pwd."';". PHP_EOL);
    fwrite($file,"\$event = '".$event."';". PHP_EOL);
    fwrite($file,"\$qrtext = '".$qrtext."';". PHP_EOL);
    fwrite($file,"\$qrcodesize = ".$qrcodesize.";". PHP_EOL);
    fwrite($file,"\$dbhost = '".$dbhost."';". PHP_EOL);
    fwrite($file,"\$dbuser = '".$dbuser."';". PHP_EOL);
    fwrite($file,"\$dbpass = '".$dbpass."';". PHP_EOL);
    fwrite($file,"\$dbbase = '".$dbbase."';". PHP_EOL);
    fwrite($file,"\$dbport = ".$dbport.";". PHP_EOL);
    fwrite($file,"\$defaultLang = '".$defaultLang."';". PHP_EOL);
    
    if($showlang == "on")
        fwrite($file,"\$showlang = true;". PHP_EOL);
    else
        fwrite($file,"\$showlang = false;". PHP_EOL);
        
    if($footernav == "on")
        fwrite($file,"\$footernav = true;". PHP_EOL);
    else
        fwrite($file,"\$footernav = false;". PHP_EOL);

    if($credits == "on")
        fwrite($file,"\$credits = true;". PHP_EOL);
    else
        fwrite($file,"\$credits = false;". PHP_EOL);

    if($showrelease == "on")
        fwrite($file,"\$showrelease = true;". PHP_EOL);
    else
        fwrite($file,"\$showrelease = false;". PHP_EOL);

    if($export == "on")
        fwrite($file,"\$export = true;". PHP_EOL);
    else
        fwrite($file,"\$export = false;". PHP_EOL);

    if($cookieconsent == "on")
        fwrite($file,"\$cookieconsent = true;". PHP_EOL);
    else
        fwrite($file,"\$cookieconsent = false;". PHP_EOL);

    fwrite($file,"\$release = '".$release."';". PHP_EOL);
    fclose($file);

    $status->setMsg($output['setupUpdated']);
}


// Startup
if(!file_exists("config.php")) {
    $status->setMsg($output["setupWelcomeMsg"]);
    $dbstatus = "Danger";

    $pwd = 'sbdj';
    $event = 'SB DJ';
    $qrtext = '<h3>Playlist?<br />Wishlist?</h3><p>Scan now and jump into the new world of entertainment.</p>';
    $qrcodesize = 100;
    $dbhost = 'localhost';
    $dbuser = '';
    $dbpass = '';
    $dbbase = '';
    $dbport = 3306;
    $defaultLang = 'en';
    $showlang = true;
    $footernav = true;
    $credits = true;
    $showrelease = true;
    $export = true;
    $cookieconsent = true;

} else {
    include("config.php");

    $db = new mysqli($dbhost, $dbuser, $dbpass, $dbbase, $dbport);
    if($db->connect_errno) {
        $dbstatus = "Danger";
    } else {
        $dbstatus = "Refresh";
        $db->close();
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome · Willkommen · Bienvenido · Bienvenue &middot; SB DJ</title>
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
            <h1>SB DJ · <?=$output['setupWelcome'];?></h1>
            
            <div id="btn">
                <a href='javascript:document.forms["frmSetup"].submit()' class='btnRefresh'><i class="icofont-check"></i> <small><?=$output['setupUpdate'];?></small></a>
                <a href='backend.php' class='btnDefault'><i class="icofont-logout"></i></a>
                
                <!-- DB STATUS BUTTON -->
                <a href='#' class='btn<?=$dbstatus;?>'><i class="icofont-database"></i> <small><?=$output['setupDatabase'];?></small></a>
            </div>
            
            <div id="msg">
                <?=$status->printMsg();?>
            </div>
        </div>
    </div>
        
    <form action="setup.php?do=update" method="POST" name="frmSetup">

        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="box content">
                    <h2><?=$output['setupGlobal'];?></h2>
                
                    <div class="item">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <?=$output["setupDbHost"];?>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <input type="text" value="<?=$dbhost;?>" placeholder="<?=$output["setupDbHost"];?>" name="dbhost">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <?=$output["setupDbBase"];?>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <input type="text" value="<?=$dbbase;?>" placeholder="<?=$output["setupDbBase"];?>" name="dbbase">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <?=$output["setupDbUser"];?>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <input type="text" value="<?=$dbuser;?>" placeholder="<?=$output["setupDbUser"];?>" name="dbuser">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <?=$output["setupDbPass"];?>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <input type="text" value="<?=$dbpass;?>" placeholder="<?=$output["setupDbPass"];?>" name="dbpass">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <?=$output["setupDbPort"];?>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <input type="text" value="<?=$dbport;?>" placeholder="<?=$output["setupDbPort"];?>" name="dbport">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <?=$output["setupFooternav"];?>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <input type="checkbox" class="checkbox" name="footernav" <?php if($footernav) echo "checked"; ?>>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <?=$output["setupCredits"];?>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <input type="checkbox" class="checkbox" name="credits" <?php if($credits) echo "checked"; ?>>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <?=$output["setupShowRelease"];?>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <input type="checkbox" class="checkbox" name="showrelease" <?php if($showrelease) echo "checked"; ?>>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="box content">
                    <h2><?=$output['setupEvent'];?></h2>

                    <div class="item">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <?=$output["setupEventname"];?>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <input type="text" value="<?=$event;?>" placeholder="<?=$output["setupEventname"];?>" name="event">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <?=$output["password"];?>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <input type="text" value="<?=$pwd;?>" placeholder="<?=$output['password'];?>" name="pwd">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <?=$output["setupDefaultLanguage"];?>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <input type="text" value="<?=$defaultLang;?>" placeholder="<?=$output["setupDefaultLanguage"];?>" name="defaultLang">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <?=$output["setupShowLanguage"];?>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <input type="checkbox" class="checkbox" name="showlang" <?php if($showlang) echo "checked"; ?>>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <?=$output["setupAllowExport"];?>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <input type="checkbox" class="checkbox" name="export" <?php if($export) echo "checked"; ?>>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <?=$output["setupCookieConsent"];?>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <input type="checkbox" class="checkbox" name="cookieconsent" <?php if($cookieconsent) echo "checked"; ?>>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="box content">
                    <h2><?=$output['setupQRFlyer'];?></h2>

                    <div class="item">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <?=$output['setupQrtext'];?>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <textarea name="qrtext" placeholder="<?=$output['setupQrtext'];?>" rows="5"><?=$qrtext;?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <?=$output["setupQrcodeSize"];?>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <input type="text" value="<?=$qrcodesize;?>" placeholder="<?=$output["setupQrcodeSize"];?>" name="qrcodesize">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>

<?php 
// Language settings
$showlang = true;
$footernav = false;
$credits = true;
$showrelease = true;
include("footer.php"); 
?>

</body>
</html>    