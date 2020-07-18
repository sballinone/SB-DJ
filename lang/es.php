<?php
$output = array();

$output["langName"] = "Español";
$output["langCredits"] = "Traducido por Saskia Brückner";

// General
$output["yes"] = "Sí";
$output["no"] = "No";
$output["password"] = "Contraseña";
$output["passwordIncorrect"] = "Lo siento, el contraseña no ha sido correcto.\\n\\nPruebalo otra vez, por favor.";
$output["login"] = "Iniciar";

// Main interface
$output["artist"] = "artista";
$output["back"] = "Atrás";
$output["export"] = "Exportar";
$output["playlist"] = "Lista de reproducción";
$output["qrflyer"] = "QR Flyer";
$output["refresh"] = "Recargar";
$output["setlist"] = "Setlist";
$output["title"] = "Pista";
$output["wishlist"] = "Lista de deseos";

// Cookie consent
$output["allow"] = "Permitir cookies";
$output["cookieconsent"] = "Queremos guardar cookies por algunos funcionalidades como el voting or los deseos. Esos datos se guardan en tu ordenador. Sin cookies, no podemos provedar estos funcionalidades. ";

// action.php
$output["actionPHPaccept"] = "Canción #".strip_tags($_GET['id'])." aceptado.";
$output["actionPHPadd"] = "Canción <i>".ucwords(strip_tags($_POST['title']))."</i> añadido.";
$output["actionPHPaddsetlist"] = "Canción <i>".ucwords(strip_tags($_POST['title']))."</i> añadido.";
$output["actionPHPaddsetlistAlreadyOnSetlist"] = "Lo siento, la canción <i>".ucwords(strip_tags($_POST['title']))."</i> ya está en la lista.";
$output["actionPHPaddWishAlreadyOnWishlist"] = "Lo siento, la canción <i>".ucwords(strip_tags($_POST['title']))."</i> ya está en la lista de deseos.";
$output["actionPHPaddWishAlreadyPlayed"] = "Lo siento, la canción <i>".ucwords(strip_tags($_POST['title']))."</i> ya ha sido reproducida.";
$output["actionPHPaddWishSuccess"] = "Yo he añadido la canción <i>".ucwords(strip_tags($_POST['title']))."</i> a la lista de deseos.";
$output["actionPHPcookieIssue"] = "Lo siento, tienes que permitir cookies para usar esta funcción. <a href='javascript:allowcookies()'>Permitir cookies</a>";
$output["actionPHPdeclined"] = "Canción #".strip_tags($_GET['id'])." rechazado.";
$output["actionPHPexportSuccess"] = "La lista de reproducción se ha exportada con éxito. <a href='export.csv' target='_blank'>Abra CSV</a>";
$output["actionPHPmovetoset"] = "Lo siento, la canción <i>".ucwords(strip_tags($song['title']))."</i> ya está en la lista. ¿Quieres borrarla de la lista de deseos? ";
$output["actionPHPmovetosetSuccess"] = "Canción <i>".$song['title']."</i> pospuesto.";
$output["actionPHPplay"] = "Canción <i>".$song['title']."</i> pospuesto a la lista de reproducción.";
$output["actionPHPplayFromSet"] = "Canción <i>".$song['title']."</i> copiado a la lista de reproducción.";
$output["actionPHPremove"] = "Canción #".strip_tags($_GET['id'])." borrado.";
$output["actionPHPreset"] = "¿Restablecer todo? Eso va a borrar la lista de deseos y la lista de reproducción. ";
$output["actionPHPresetSetlist"] = "¿Restablecer lista? ";
$output["actionPHPresetSetlistSuccess"] = "Lista restablecida con éxito.";
$output["actionPHPresetSuccess"] = "Restablecido con éxito.";
$output["actionPHPresetWishlist"] = "¿Restablecer lista de deseos? ";
$output["actionPHPresetWishlistSuccess"] = "Lista de deseos restablecida con éxito.";
$output["actionPHPvoteDublicate"] = "¡Ay no! Ya has votado por la canción <i>".$votes["title"]."</i>.";
$output["actionPHPvoteSuccess"] = "¡Yeah! Has votado por <i>".$votes["title"]."</i>.";

// setup.php
$output["setupAllowExport"] = "Activar exportar de la lista de reproducción";
$output["setupCookieConsent"] = "Mostrar EU Cookie Consent";
$output["setupCredits"] = "Ayudanos y cuenta de SB DJ";
$output["setupDatabase"] = "DB estado";
$output["setupDbBase"] = "MySQL base de datos";
$output["setupDbHost"] = "MySQL host";
$output["setupDbPass"] = "MySQL contraseño";
$output["setupDbPort"] = "MySQL puerto";
$output["setupDbUser"] = "MySQL usario";
$output["setupDefaultLanguage"] = "Idioma predeterminado";
$output["setupEvent"] = "Evento";
$output["setupEventname"] = "Titulo de evento";
$output["setupFooternav"] = "Mostrar accesos directos de DJ";
$output["setupGlobal"] = "Configuración global";
$output["setupQrcodeSize"] = "Código QR in px";
$output["setupQRFlyer"] = "QR Flyer";
$output["setupQrtext"] = "Texto en QR Flyer";
$output["setupShowLanguage"] = "Mostrar selección de idioma";
$output["setupShowRelease"] = "Mostrar lanzamiento de applicación";
$output["setupUpdate"] = "Guardar configuración";
$output["setupUpdated"] = "Configuración guardado";
$output["setupWelcome"] = "Bienvenido";
$output["setupWelcomeMsg"] = "¡Hola! Me alegro mucho a verte. Confígura la base de datos y configuraciones del evento y ya estás listo. Disfruta SB DJ.";