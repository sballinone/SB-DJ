<?php

if(!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2); 
}

if(isset($_GET['lang'])) {
    $_SESSION['lang'] = strip_tags($_GET['lang']);
}

if(!file_exists("lang/".$_SESSION['lang'].".php")) {
    $_SESSION['lang'] = $defaultLang;
    include("lang/".$defaultLang.".php");
} else {
    include("lang/".$_SESSION['lang'].".php");
}
