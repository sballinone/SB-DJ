<?php
// Your login password
$pwd = "";

// The name of your event. Do NOT use "
$event = "SB DJ";

// The text on the QR Code Flyer
// 
// Important notes below! Errors may break your QR Code Flyer!
//
// Use <h3>Title</h3> for a title
// Use <p>Text</p> for a standard text. Every <p> has to be closed by a </p>
// Use <br /> for a line break
// 
// You can add as many $qrtext .= "Your text"; as you want. 
// Please take care of the dot equal (.=) beginning on the second line.
// Close every line with a semicolon ; at the end as seen below.
// Do not use "
// 
// If you broke your QR Code Flyer:
// Delete the lines with $qrtext at the beginning and paste the following two lines (without // at the beginning):
// $qrtext = "<h3>Title</h3>";
// $qrtext .= "<p>Text</p>";
//
// You may change the complete appearance of the QR Code Flyer by editing css/qrcode.css
$qrtext = "<h3>Playlist?<br />Wishlist?</h3>";
$qrtext .= "<p>Dein Song auf der Tanzfläche? Wünsch ihn dir einfach! ";
$qrtext .= "Finde alle gespielten Songs auf der Playlist. ";
$qrtext .= "Gleich scannen und dabei sein</p>";

// Size of QR Code
$qrcodesize = 100;

// Database configuration
$dbhost = "localhost";
$dbuser = "sbdj";
$dbpass = "sbdj";
$dbbase = "sbdj";
$dbport = 8889;

// Footer configuration
$footernav = true;
$credits = true;
$showrelease = true; // helpful for debugging

// Allow or prohibit export
$export = true;

// Do not change
$release = "2020.0";
