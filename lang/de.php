<?php
$output = array();

$output["langName"] = "Deutsch";
$output["langCredits"] = "Übersetzt von Saskia Brückner";

// General
$output["yes"] = "Ja";
$output["no"] = "Nein";
$output["password"] = "Passwort";
$output["passwordIncorrect"] = "Sorry, das Passwort ist nicht korrekt.\\n\\nBitte versuche es noch einmal.";
$output["login"] = "Anmelden";

// Main interface
$output["artist"] = "Interpret";
$output["back"] = "Zurück";
$output["export"] = "Exportieren";
$output["playlist"] = "Playliste";
$output["qrflyer"] = "QR Flyer";
$output["refresh"] = "Neu laden";
$output["setlist"] = "Setliste";
$output["title"] = "Titel";
$output["wishlist"] = "Wunschliste";

// Cookie consent
$output["allow"] = "Cookies erlauben";
$output["cookieconsent"] = "Wir benötigen Cookies, um manche Funktionen wie Voting oder die Wunschliste bereitstellen zu können. Cookies sind kleine Dateien, die auf deinem Gerät gespeichert werden. Ohne sie können manche Funktionen nicht umgesetzt werden. ";

// action.php
$output["actionPHPaccept"] = "Song #".strip_tags($_GET['id'])." akzeptiert.";
$output["actionPHPadd"] = "Song <i>".ucwords(strip_tags($_POST['title']))."</i> hinzugefügt.";
$output["actionPHPaddsetlist"] = "Song <i>".ucwords(strip_tags($_POST['title']))."</i> hinzugefügt.";
$output["actionPHPaddsetlistAlreadyOnSetlist"] = "Sorry, der Song <i>".ucwords(strip_tags($_POST['title']))."</i> ist schon auf der Setliste.";
$output["actionPHPaddWishAlreadyOnWishlist"] = "Sorry, der Song <i>".ucwords(strip_tags($_POST['title']))."</i> ist schon auf der Wunschliste.";
$output["actionPHPaddWishAlreadyPlayed"] = "Sorry, der Song <i>".ucwords(strip_tags($_POST['title']))."</i> wurde schon gespielt.";
$output["actionPHPaddWishSuccess"] = "Ich habe dein Wunsch <i>".ucwords(strip_tags($_POST['title']))."</i> hinzugefügt.";
$output["actionPHPcookieIssue"] = "Sorry, du musst Cookies erlauben, um diese Funktion nutzen zu können. <a href='javascript:allowcookies()'>Cookies erlauben</a>";
$output["actionPHPdeclined"] = "Song #".strip_tags($_GET['id'])." abgelehnt.";
$output["actionPHPexportSuccess"] = "Playliste erfolgreich exportiert. <a href='export.csv' target='_blank'>Öffne CSV</a>";
$output["actionPHPexportSuccessCust"] = "Playliste erfolgreich exportiert. <a href='export_cust.csv' target='_blank'>Öffne CSV</a>";
$output["actionPHPmovetoset"] = "Sorry, der Song <i>".ucwords(strip_tags($song['title']))."</i> ist bereits auf der Setliste. Wunsch löschen? ";
$output["actionPHPmovetosetSuccess"] = "Song <i>".$song['title']."</i> verschoben.";
$output["actionPHPplay"] = "Song <i>".$song['title']."</i> auf die Playliste verschoben.";
$output["actionPHPplayFromSet"] = "Song <i>".$song['title']."</i> auf die Playiste kopiert.";
$output["actionPHPremove"] = "Song #".strip_tags($_GET['id'])." gelöscht.";
$output["actionPHPreset"] = "Alles zurücksetzen? Dies löscht die Wunschliste und die Playliste. ";
$output["actionPHPresetSetlist"] = "Setliste zurücksetzen? ";
$output["actionPHPresetSetlistSuccess"] = "Setliste erfolgreich zurückgesetzt.";
$output["actionPHPresetSuccess"] = "Reset erfolgreich.";
$output["actionPHPresetWishlist"] = "Wunschliste zurücksetzen? ";
$output["actionPHPresetWishlistSuccess"] = "Wunschliste erfolgreich zurückgesetzt.";
$output["actionPHPvoteDublicate"] = "Oh nein! Du hast bereits für den Song <i>".$votes["title"]."</i> abgestimmt.";
$output["actionPHPvoteSuccess"] = "Yeah! Du hast für <i>".$votes["title"]."</i> abgestimmt.";

// setup.php
$output["setupAllowExport"] = "Aktiviere Playlist-Export";
$output["setupCookieConsent"] = "Zeige EU Cookie Consent";
$output["setupCredits"] = "Unterstütze uns und aktiviere Credits";
$output["setupDatabase"] = "DB Status";
$output["setupDbBase"] = "MySQL Datenbank";
$output["setupDbHost"] = "MySQL Host";
$output["setupDbPass"] = "MySQL Passwort";
$output["setupDbPort"] = "MySQL Port";
$output["setupDbUser"] = "MySQL Benutzer";
$output["setupDefaultLanguage"] = "Standardsprache";
$output["setupEvent"] = "Event";
$output["setupEventname"] = "Titel des Events";
$output["setupFooternav"] = "Zeige DJ Shortcuts";
$output["setupGlobal"] = "Globale Einstellungen";
$output["setupQrcodeSize"] = "QR Code in px";
$output["setupQRFlyer"] = "QR Flyer";
$output["setupQrtext"] = "Text auf QR Flyer";
$output["setupShowLanguage"] = "Zeige Sprachauswahl";
$output["setupShowRelease"] = "Zeige Softwarerelease";
$output["setupUpdate"] = "Speichere Konfiguration";
$output["setupUpdated"] = "Konfiguration gespeichert";
$output["setupWelcome"] = "Willkommen";
$output["setupWelcomeMsg"] = "Hi! Ich freue mich, dich zu sehen. Du wirst begeistert sein. Konfiguriere deine Datenbank und Event-Einstellungen und du bist bereit loszulegen. Geniesse SB DJ.";