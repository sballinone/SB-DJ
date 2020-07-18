# SB-DJ

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sballinone/SB-DJ/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sballinone/SB-DJ/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/sballinone/SB-DJ/badges/build.png?b=master)](https://scrutinizer-ci.com/g/sballinone/SB-DJ/build-status/master)
[![Release](https://badgen.net/badge/release/2020.1/cyan)](https://github.com/sballinone/SB-DJ/releases/)

DJ Compagnon app

![Mockup](external/mockup.png)

**SETLIST** Create your setlist and enjoy full playlist integration. Ask your guests before your event and add wishes to the setlist.

**WISHLIST** Are you tired of guests interupting you with their wishes? As your Co-DJ, SB DJ allowes your guests sending their wishes without interupting you.

**PLAYLIST** Create your playlist and CSV-export it at the end of the night.

**QR CODE FLYER** Allow your guests to access the public part of SB DJ quickly by printing flyers with a QR Code.

**WE SPEAK YOUR LANGUAGE** Provide your guests a localized experience. English, Spanisch and German built in. You can add as many languages as you want.

**BUILT IN SECURITY** Secure your actor's part of the software from the public part. Disallow "double-votes" on wishes. High code quality.

* * *

## Changelog

See [CHANGELOG.md](CHANGELOG.md)

* * *

## Requirements

-   This software needs a Webserver with PHP, MySQL

## Installation

-   Upload your files onto your webserver, import database.sql into your mysql database and open SB DJ in your webbrowser. Your webbrowser should redirect you to setup.php.
-   If you have enabled shortcuts, you find the buttons "FE" and "BE" on the bottom. Press "BE" to enter the DJ interface of the software. 
-   If you have disabled shortcuts, open backend.php to view the backend.

## Translation

-   You may add as many languages as you want: Just copy the file ./lang/en.php, paste the new file named with the two letter language code (e.G. fr.php for French) and translate everything after the = operators. Remember not to change vars.

    Example: 

    English: $output["welcome"] = "Welcome ".$\_SESSION["firstname"]; 

    German: $output["welcome"] = "Willkommen ".$\_SESSION["firstname"];

* * *

## Thank you

For this software we used some open source projects:

-   IcoFont - <https://icofont.com>
-   Google Webfonts - <https://fonts.google.com>
-   Google Webfont Helper - <https://google-webfonts-helper.herokuapp.com/fonts>
-   goQR.com QR Code Generator - <https://goqr.me/api/>

Thank you to the open source community.
