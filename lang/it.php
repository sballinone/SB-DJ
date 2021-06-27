<?php
$output = array();

$output["langName"] = "Italiano";
$output["langCredits"] = "Tradotto da DeepL.com. Incompleto e imperfetto.";

// Generale
$output["yes"] = "Sì";
$output["no"] = "No";
$output["password"] = "password";
$output["passwordIncorrect"] = "Spiacente, la password non è corretta";
$output["login"] = "Accedi";

// Interfaccia principale
$output["artist"] = "Artista";
$output["back"] = "Torna";
$output["export"] = "Export";
$output["import"] = "Import";
$output["importfile"] = "File CSV da djay: ";
$output["playlist"] = "Lista di riproduzione".
$output["qrflyer"] = "QR Flyer";
$output["refresh"] = "Ricarica";
$output["setlist"] = "setlist";
$output["title"] = "titolo";
$output["wishlist"] = "Lista dei desideri";

// consenso dei cookie
$output["allow"] = "Permettere i cookie";
$output["cookieconsent"] = "Abbiamo bisogno di cookie per fornire alcune funzionalità come il voto o la Lista dei desideri. I cookie sono piccoli file che vengono memorizzati sul suo dispositivo. Senza di loro, alcune funzioni non possono essere implementate. ";

// azione.php
$output["actionPHPaccept"] = "Canzone #".strip_tags($_GET['id'])." accettato.";
$output["actionPHPadd"] = "Canzone <i>".ucwords(strip_tags($_POST['title']))."</i> aggiunta";
$output["actionPHPaddsetlist"] = "Canzone <i>".ucwords(strip_tags($_POST['title']))."</i> aggiunta";
$output["actionPHPaddsetlistAlreadyOnSetlist"] = "Spiacente, la canzone <i>".ucwords(strip_tags($_POST['title']))."</i> è già nella setlist";
$output["actionPHPaddWishAlreadyOnWishlist"] = "Spiacente, la canzone <i>".ucwords(strip_tags($_POST['title']))."</i> è già nella Lista dei desideri";
$output["actionPHPaddWishAlreadyPlayed"] = "Spiacente, la canzone <i>".ucwords(strip_tags($_POST['title']))."</i> è già stata riprodotta";
$output["actionPHPaddWishSuccess"] = "Ho aggiunto il tuo desiderio <i>".ucwords(strip_tags($_POST['title']))."</i>.";
$output["actionPHPcookieIssue"] = "Spiacente, è necessario consentire i cookie per utilizzare questa funzione. <a href='javascript:allowcookies()'>Permettere cookies</a>";
$output["actionPHPdeclined"] = "Canzone #".strip_tags($_GET['id'])." rifiutata.";
$output["actionPHPexportSuccess"] = "Lista di riproduzione esportata con successo. <a href='export.csv' target='_blank'>Aprire CSV</a>";
$output["actionPHPexportSuccessCust"] = "Lista di riproduzione esportata con successo. <a href='export_cust.csv' target='_blank'>Apri CSV</a>";
$output["actionPHPmovetoset"] = "Spiacente, la canzone <i>".ucwords(strip_tags($song['title']))."</i> è già in scaletta. Desiderate cancellare? ";
$output["actionPHPmovetosetSuccess"] = "Canzone <i>".$song['title']."</i> spostata.";
$output["actionPHPplay"] = "Canzone <i>".$song['title']."</i> spostata nella playlist.";
$output["actionPHPplayFromSet"] = "Canzone <i>".$song['title']."</i> copiata nella playlist";
$output["actionPHPremove"] = "Canzone #".strip_tags($_GET['id'])." cancellato";
$output["actionPHPreset"] = "Resettare tutto? Questo cancellerà la lista dei desideri e la playlist. ";
$output["actionPHPresetSetlist"] = "Reset setlist? ";
$output["actionPHPresetSetlistSuccess"] = "Reset setlist successfully.";
$output["actionPHPresetSuccess"] = "Reset riuscito";
$output["actionPHPresetWishlist"] = "Reset wishlist? ";
$output["actionPHPresetWishlistSuccess"] = "Reset wishlist successfully.";
$output["actionPHPvoteDublicate"] = "Oh no! Hai già votato per la canzone <i>".$votes["title"]."</i>.";
$output["actionPHPvoteSuccess"] = "Yeah! Hai votato per <i>".$votes["title"]."</i>";

// setup.php
$output["setupAllowExport"] = "Abilita l'esportazione della playlist";
$output["setupCookieConsent"] = "Mostra EU Cookie Consent";
$output["setupCredits"] = "Sostienici e attiva i crediti";
$output["setupDatabase"] = "Stato del DB";
$output["setupDbBase"] = "Database MySQL";
$output["setupDbHost"] = "MySQL Host";
$output["setupDbPass"] = "Password MySQL";
$output["setupDbPort"] = "MySQL Port";
$output["setupDbUser"] = "MySQL User";
$output["setupDefaultLanguage"] = "Lingua predefinita";
$output["setupEvent"] = "Evento";
$output["setupEventname"] = "Titolo dell'evento";
$output["setupFooternav"] = "Mostra i collegamenti DJ";
$output["setupGlobal"] = "Impostazioni globali";
$output["setupQrcodeSize"] = "QR Code in px";
$output["setupQRFlyer"] = "QR Flyer";
$output["setupQrtext"] = "Testo sul volantino QR";
$output["setupShowLanguage"] = "Mostra la selezione della lingua";
$output["setupShowRelease"] = "Mostra la versione del software";
$output["setupUpdate"] = "Salva la configurazione";
$output["setupUpdated"] = "Salva la configurazione";
$output["setupWelcome"] = "Welcome";
$output["setupWelcomeMsg"] = "Ciao, sono felice di vederti. Ne sarete entusiasti. Configura il tuo database e le impostazioni degli eventi e sei pronto a partire. Goditi SB DJ".

// upload.php
$output["uploadFailed"] = "Spiacente, non ho potuto caricare il file";
$output["uploadSuccess"] = "Il file ".basename( $_FILES["importfile"]["name"])." è stato caricato";
$output["uploadWrongFileType"] = "Spiacente, accetto solo file CSV creati da djay.";
