<?php
$output = array();

$output["langName"] = "English (US)";
$output["langCredits"] = "Translated by Saskia Brückner";

// General
$output["yes"] = "Yes";
$output["no"] = "No";
$output["password"] = "Password";
$output["passwordIncorrect"] = "Sorry, the password you entered isn\'t correct.\\n\\nPlease try again.";
$output["login"] = "Login";

// Main interface
$output["artist"] = "Artist";
$output["back"] = "Back";
$output["export"] = "Export";
$output["playlist"] = "Playlist";
$output["qrflyer"] = "QR Flyer";
$output["refresh"] = "Refresh";
$output["setlist"] = "Setlist";
$output["title"] = "Title";
$output["wishlist"] = "Wishlist";

// Cookie consent
$output["allow"] = "Allow cookies";
$output["cookieconsent"] = "We want to use cookies for some functionalities like voting or wishing. Cookies are small pieces of data stored on your device. Without them, we are not able to provide some functionalities. ";

// action.php
$output["actionPHPaccept"] = "Song #".strip_tags($_GET['id'])." accepted.";
$output["actionPHPadd"] = "Song <i>".ucwords(strip_tags($_POST['title']))."</i> added.";
$output["actionPHPaddsetlist"] = "Song <i>".ucwords(strip_tags($_POST['title']))."</i> added.";
$output["actionPHPaddsetlistAlreadyOnSetlist"] = "Sorry, the song <i>".ucwords(strip_tags($_POST['title']))."</i> is already on the setlist.";
$output["actionPHPaddWishAlreadyOnWishlist"] = "Sorry, the song <i>".ucwords(strip_tags($_POST['title']))."</i> is already on the wishlist.";
$output["actionPHPaddWishAlreadyPlayed"] = "Sorry, the song <i>".ucwords(strip_tags($_POST['title']))."</i> already has been played.";
$output["actionPHPaddWishSuccess"] = "I added your wish <i>".ucwords(strip_tags($_POST['title']))."</i>.";
$output["actionPHPcookieIssue"] = "Sorry, you need to allow cookies. <a href='javascript:allowcookies()'>Allow cookies</a>";
$output["actionPHPdeclined"] = "Song #".strip_tags($_GET['id'])." declined.";
$output["actionPHPexportSuccess"] = "Playlist successfully exported. <a href='export.csv' target='_blank'>Open CSV</a>";
$output["actionPHPmovetoset"] = "Sorry, the song <i>".ucwords(strip_tags($song['title']))."</i> is already on the setlist. Remove wish? ";
$output["actionPHPmovetosetSuccess"] = "Song <i>".$song['title']."</i> moved.";
$output["actionPHPplay"] = "Song <i>".$song['title']."</i> moved to playlist.";
$output["actionPHPplayFromSet"] = "Song <i>".$song['title']."</i> copied to playlist.";
$output["actionPHPremove"] = "Song #".strip_tags($_GET['id'])." removed.";
$output["actionPHPreset"] = "Reset all? This clears the wishlist and the playlist. ";
$output["actionPHPresetSetlist"] = "Reset setlist? ";
$output["actionPHPresetSetlistSuccess"] = "Setlist reset successful.";
$output["actionPHPresetSuccess"] = "Reset successful.";
$output["actionPHPresetWishlist"] = "Reset wishlist? ";
$output["actionPHPresetWishlistSuccess"] = "Wishlist reset successful.";
$output["actionPHPvoteDublicate"] = "Oh no! You already voted for <i>".$votes["title"]."</i>.";
$output["actionPHPvoteSuccess"] = "Yeah! You voted for <i>".$votes["title"]."</i>.";

// setup.php
$output["setupAllowExport"] = "Allow playlist export";
$output["setupCookieConsent"] = "Show EU Cookie Consent";
$output["setupCredits"] = "Support us ans view credits";
$output["setupDatabase"] = "DB status";
$output["setupDbBase"] = "MySQL Database";
$output["setupDbHost"] = "MySQL Host";
$output["setupDbPass"] = "MySQL Password";
$output["setupDbPort"] = "MySQL Port";
$output["setupDbUser"] = "MySQL User";
$output["setupDefaultLanguage"] = "Default language";
$output["setupEvent"] = "Event";
$output["setupEventname"] = "Event title";
$output["setupFooternav"] = "Show shortcuts for DJ";
$output["setupGlobal"] = "Global settings";
$output["setupQrcodeSize"] = "QR Code in px";
$output["setupQRFlyer"] = "QR Flyer";
$output["setupQrtext"] = "Text on QR Flyer";
$output["setupShowLanguage"] = "Show language selector";
$output["setupShowRelease"] = "Show the software release";
$output["setupUpdate"] = "Save configuration";
$output["setupUpdated"] = "Settings saved";
$output["setupWelcome"] = "Welcome";
$output["setupWelcomeMsg"] = "Hi! Nice to see you. You will be amazed. Configure your database and event settings and you're ready to go. Enjoy SB DJ.";