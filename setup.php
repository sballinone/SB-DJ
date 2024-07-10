<?php
$release = "2024.1.1";

session_start();

// Check if config exists.
if (file_exists("config.php") && !isset($_SESSION['backend'])) {
	session_destroy();
	header("Location: login.php");
	exit;
}

include("inc/localization.php");
include("class/CMsg.php");
$status = new CMsg();

$dbstatus = "Default";


// Save config
if (isset($_GET['do'])) {
	$_SESSION['backend'] = true;
	
	// Read the formular
	$pwd = htmlspecialchars($_POST['pwd']);
	$event = htmlspecialchars($_POST['event']);
	$qrtext = strip_tags($_POST['qrtext'], "<h3></h3><br><br /><p></p>");
	$qrcodesize = htmlspecialchars($_POST['qrcodesize']);
	$dbhost = htmlspecialchars($_POST['dbhost']);
	$dbuser = htmlspecialchars($_POST['dbuser']);
	$dbpass = htmlspecialchars($_POST['dbpass']);
	$dbbase = htmlspecialchars($_POST['dbbase']);
	$dbport = htmlspecialchars($_POST['dbport']);
	$defaultLang = htmlspecialchars($_POST['defaultLang']);
	
	if(isset($_POST['showlang'])) {
		$showlang = htmlspecialchars($_POST['showlang']); 
	} else {
		$showlang = false;
	}
	if(isset($_POST['footernav'])) {
		$footernav = htmlspecialchars($_POST['footernav']);
	} else {
		$footernav = false;
	}
	if(isset($_POST['credits'])) {
		$credits = htmlspecialchars($_POST['credits']);
	} else {
		$credits = false;
	}
	if(isset($_POST['showrelease'])) {
		$showrelease = htmlspecialchars($_POST['showrelease']);
	} else {
		$showrelease = false;
	}
	if(isset($_POST['export'])) {
		$export = htmlspecialchars($_POST['export']);
	} else {
		$export = false;
	}
	if(isset($_POST['cookieconsent'])) {
		$cookieconsent = htmlspecialchars($_POST['cookieconsent']);
	} else {
		$cookieconsent = false;
	}
	
	// Write config file
	$file = fopen("config.php", "w");
	fwrite($file, "<?php ".PHP_EOL);
	fwrite($file, "// Automatically created by SB DJ ".PHP_EOL);
	fwrite($file, "// ".date('d.m.Y H:i').PHP_EOL);
	fwrite($file, "\$pwd = '".$pwd."';".PHP_EOL);
	fwrite($file, "\$event = '".$event."';".PHP_EOL);
	fwrite($file, "\$qrtext = '".$qrtext."';".PHP_EOL);
	fwrite($file, "\$qrcodesize = ".$qrcodesize.";".PHP_EOL);
	fwrite($file, "\$dbhost = '".$dbhost."';".PHP_EOL);
	fwrite($file, "\$dbuser = '".$dbuser."';".PHP_EOL);
	fwrite($file, "\$dbpass = '".$dbpass."';".PHP_EOL);
	fwrite($file, "\$dbbase = '".$dbbase."';".PHP_EOL);
	fwrite($file, "\$dbport = ".$dbport.";".PHP_EOL);
	fwrite($file, "\$defaultLang = '".$defaultLang."';".PHP_EOL);
	
	if ($showlang == "on") {
		fwrite($file, "\$showlang = true;".PHP_EOL);
	} else {
		fwrite($file, "\$showlang = false;".PHP_EOL);
	}
		
	if ($footernav == "on") {
		fwrite($file, "\$footernav = true;".PHP_EOL);
	} else {
		fwrite($file, "\$footernav = false;".PHP_EOL);
	}

	if ($credits == "on") {
		fwrite($file, "\$credits = true;".PHP_EOL);
	} else {
		fwrite($file, "\$credits = false;".PHP_EOL);
	}

	if ($showrelease == "on") {
		fwrite($file, "\$showrelease = true;".PHP_EOL);
	} else {
		fwrite($file, "\$showrelease = false;".PHP_EOL);
	}

	if ($export == "on") {
		fwrite($file, "\$export = true;".PHP_EOL);
	} else {
		fwrite($file, "\$export = false;".PHP_EOL);
	}

    if ($cookieconsent == "on") {
        fwrite($file, "\$cookieconsent = true;".PHP_EOL);
    } else {
        fwrite($file, "\$cookieconsent = false;".PHP_EOL);
    }

	fwrite($file, "\$release = '".$release."';".PHP_EOL);
	fclose($file);

	$status->setMsg(_("Settings saved"));
}


// Startup
if (!file_exists("config.php")) {
	
	$status->setMsg(_("Hi! Nice to see you. You will be amazed. Configure your database and event settings and you're ready to go. Enjoy SB DJ."));
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
	$defaultLang = 'en_US';
	$showlang = true;
	$footernav = true;
	$credits = true;
	$showrelease = true;
	$export = true;
	$cookieconsent = true;

} else {
	include("config.php");

	$db = new mysqli($dbhost, $dbuser, $dbpass, $dbbase, $dbport);
	if ($db->connect_errno) {
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
			
			<div id="btn">
				<a href='javascript:document.forms["frmSetup"].submit()' class='btnRefresh'><i class="icofont-check"></i> <small><?=_("Save configuration"); ?></small></a>
				<a href='backend.php' class='btnDefault'><i class="icofont-logout"></i></a>
				
				<!-- DB STATUS BUTTON -->
				<a href='#' class='btn<?=$dbstatus; ?>'><i class="icofont-database"></i> <small><?=_("DB status"); ?></small></a>
				
				<!-- UPDATE BUTTON -->
				<a href='#' class='btnDefault' id='btnUpdate'><i class="icofont-database"></i> <small>Checking...</small></a>
			</div>
			
			<div id="msg">
				<?=$status->printMsg(); ?>
			</div>
		</div>
	</div>
		
	<form action="setup.php?do=update" method="POST" name="frmSetup">

		<div class="row">
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<div class="box content">
					<h2><?=_("Global settings"); ?></h2>
				
					<div class="item">
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<?=_("MySQL Host"); ?>
								</div>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<input type="text" value="<?=$dbhost; ?>" placeholder="<?=_("MySQL Host"); ?>" name="dbhost">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<?=_("MySQL Database"); ?>
								</div>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<input type="text" value="<?=$dbbase; ?>" placeholder="<?=_("MySQL Database"); ?>" name="dbbase">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<?=_("MySQL User"); ?>
								</div>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<input type="text" value="<?=$dbuser; ?>" placeholder="<?=_("MySQL User"); ?>" name="dbuser">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<?=_("MySQL Password"); ?>
								</div>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<input type="text" value="<?=$dbpass; ?>" placeholder="<?=_("MySQL Password"); ?>" name="dbpass">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<?=_("MySQL Port"); ?>
								</div>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<input type="text" value="<?=$dbport; ?>" placeholder="<?=_("MySQL Port"); ?>" name="dbport">
								</div>
							</div>
						</div>
					</div>

					<div class="item">
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<?=_("Show shortcuts for DJ"); ?>
								</div>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<input type="checkbox" class="checkbox" name="footernav" <?php if ($footernav) { echo "checked"; } ?>>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box" style="text-align: left;">
									<?=_("Support me and view credits"); ?>
								</div>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<input type="checkbox" class="checkbox" name="credits" <?php if ($credits) { echo "checked"; } ?>>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box" style="text-align: left;">
									<?=_("Show the software release"); ?>
								</div>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<input type="checkbox" class="checkbox" name="showrelease" <?php if ($showrelease) { echo "checked"; } ?>>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<div class="box content">
					<h2><?=_("Event"); ?></h2>

					<div class="item">
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<?=_("Event title"); ?>
								</div>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<input type="text" value="<?=$event; ?>" placeholder="<?=_("Event title"); ?>" name="event">
								</div>
							</div>
						</div>
					</div>

					<div class="item">
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<?=_("Password"); ?>
								</div>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<input type="text" value="<?=$pwd; ?>" placeholder="<?=_("Password"); ?>" name="pwd">
								</div>
							</div>
						</div>
					</div>

					<div class="item">
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<?=_("Default language"); ?>
								</div>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<input type="text" value="<?=$defaultLang; ?>" placeholder="<?=_("Default language"); ?>" name="defaultLang">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<?=_("Show language selector"); ?>
								</div>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<input type="checkbox" class="checkbox" name="showlang" <?php if ($showlang) { echo "checked"; } ?>>
								</div>
							</div>
						</div>
					</div>

					<div class="item">
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<?=_("Allow playlist export"); ?>
								</div>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<input type="checkbox" class="checkbox" name="export" <?php if ($export) { echo "checked"; } ?>>
								</div>
							</div>
						</div>
					</div>

					<div class="item">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box" style="text-align: left;">
                                    <?=_("Show EU Cookie Consent"); ?>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="box">
                                    <input type="checkbox" class="checkbox" name="cookieconsent" <?php if ($cookieconsent) { echo "checked"; } ?>>
                                </div>
                            </div>
                        </div>
                    </div>

				</div>
			</div>

			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<div class="box content">
					<h2><?=_("QR Flyer"); ?></h2>

					<div class="item">
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<?=_("Text on QR Flyer"); ?>
								</div>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<textarea name="qrtext" placeholder="<?=_("Text on QR Flyer"); ?>" rows="5"><?=$qrtext; ?></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<?=_("QR Code in px"); ?>
								</div>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="box">
									<input type="text" value="<?=$qrcodesize; ?>" placeholder="<?=_("QR Code in px"); ?>" name="qrcodesize">
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</form>

<?php 
$showlang = true;
$footernav = false;
$credits = true;
$showrelease = true;
include("inc/footer.php"); 

echo "</div>";
?>

<script src="https://update.saskiabrueckner.com/sbdj/update.js"></script>
<?php
$releasedata = explode(".", $release);
echo "<script>var relmajor = ".$releasedata[0]."; var relminor = ".$releasedata[1]."; var relbuilt = ".$releasedata[2].";</script>";
?>
<script src="assets/js/update.js"></script>

</body>
</html>    
*/