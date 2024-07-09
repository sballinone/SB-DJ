<?php

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)."_".substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 3, 2); 
}

if (isset($_GET['lang'])) {
    $_SESSION['lang'] = htmlspecialchars($_GET['lang']);
}
if (!is_dir("lang/".$_SESSION['lang'])) {
    if(!isset($defaultLang)) {
        $_SESSION['lang'] = "de_DE"; // German until english translation exists
    } else {
        $_SESSION['lang'] = $defaultLang;
    }
} 

// Localization
if (!function_exists("gettext")) { echo "gettext is not installed"; exit; }
putenv('LC_ALL='.$_SESSION['lang']);
setlocale (LC_ALL, $_SESSION['lang']);
bindtextdomain("sbdj", "lang");
textdomain("sbdj");
