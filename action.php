<?php

/* SB DJ 
 * Release 2020.0
 * Written by Saskia Brückner
 */

if (isset($_GET['do'])) {
    switch (strip_tags($_GET['do'])) {
        case 'addwish':
            if (strip_tags($_COOKIE['allowCookies']) || !$cookieconsent) {
                // Check if song already has been played
                $sql = "SELECT title FROM playlist WHERE title LIKE '".ucwords(strip_tags($_POST['title']))."';";
                $data = $db->query($sql);

                if ($data->num_rows) {
                    $status->setMsg($output["actionPHPaddWishAlreadyPlayed"]);
                } else {
                    // Check if song already has been wished
                    $sql = "SELECT title FROM wishlist WHERE title LIKE '".ucwords(strip_tags($_POST['title']))."';";
                    $data = $db->query($sql);

                    if ($data->num_rows) {
                        $status->setMsg($output["actionPHPaddWishAlreadyOnWishlist"]);
                    } else {

                        // Insert wish into wishlist
                        $sql = 'INSERT INTO wishlist VALUES (
                            NULL,
                            "'.ucwords(strip_tags($_POST['title'])).'",
                            "'.ucwords(strip_tags($_POST['artist'])).'",
                            0,
                            0,
                            1,
                            "'.gethostname().'");';
                        $db->query($sql);

                        // Set cookie and refresh session
                        $cookie = explode(",", strip_tags($_COOKIE['wishes']));
                        array_push($cookie, $db->insert_id);
                        $cookie = implode(",", $cookie);
                        setcookie("wishes", $cookie, time() + 3600);
                        $_SESSION["wishes"] = $cookie;
                        
                        $latestwish = $db->insert_id;

                        // Output status
                        $status->setMsg($output["actionPHPaddWishSuccess"]);

                    }
                }
            } else {
                $status->setMsg($output["actionPHPcookieIssue"]);
            }
        break;

        case 'export':
            // Check if export is allowed or if dj
            if ($_SESSION['backend'] || $export) {

                // Select the songs to export
                $sql = "SELECT * FROM playlist ORDER BY id DESC;";
                $data = $db->query($sql);

                // Check if dj or guest and set filename
                $filename;
                if ($_SESSION['backend']) {
                    $filename = "export.csv";
                    $status->setMsg($output["actionPHPexportSuccess"]);
                } else {
                    $filename = "export_cust.csv";
                    $status->setMsg($output["actionPHPexportSuccessCust"]);
                }

                // Write CSV file
                $txt = fopen($filename, "w");
                fwrite(/** @scrutinizer ignore-type */ $txt, 'ID;Timestamp;Artist;Title;From Wishlist'.PHP_EOL);
                while($song = $data->fetch_assoc()) {
                    $csvline = $song["id"].";".date('Y.m.d h:i:s a', strtotime($song["timestamp"])).';'.$song["artist"].';'.$song["title"].';'.$song["waswish"].PHP_EOL;
                    fwrite(/** @scrutinizer ignore-type */ $txt, $csvline);
                }
                fclose(/** @scrutinizer ignore-type */ $txt);
            }
        break;

        case 'import':
            if (!isset($_GET['import'])) {
                $status->setMsg('<form action="backend.php?do=import&import=true" method="POST" enctype="multipart/form-data">');
                $status->setMsg($output["importfile"]);
                $status->setMsg('<br /><input type="file" name="importfile" id="importfile">&nbsp;&nbsp;&nbsp;<input type="submit" value="'.$output['import'].'" name="submit"></form>');
            } else {
                // Upload the file (outsourced for improved readability)
                include('upload.php');

                $txt = fopen($target_file, "r");
                
                // Skip the first line (titles and table header)
                $data = fgetcsv(/** @scrutinizer ignore-type */ $txt);
                
                // Do the import...
                while (!feof(/** @scrutinizer ignore-type */ $txt)) {
                    $data = fgetcsv(/** @scrutinizer ignore-type */ $txt);

                    // Format the timestamp for the database
                    $timestamp = $data[3];
                    $timestamp = explode("T", $timestamp);
                    $timestamp = $timestamp[0]." ".trim($timestamp[1], "Z");

                    // Insert into the database
                    $sql = "INSERT INTO playlist VALUES (
                        NULL,
                        '".$data[0]."',
                        '".$data[1]."',
                        '".$timestamp."',
                        0);";
                    $db->query($sql);
                }
                fclose(/** @scrutinizer ignore-type */ $txt);

                // Remove the file
                unlink($target_file);
            }
        break;

        case 'vote':
            if (strip_tags($_COOKIE['allowCookies']) || !$cookieconsent) {
                // Check if already voted
                $cookie = explode(",", strip_tags($_COOKIE['votes']));

                if (in_array($_GET['id'], $cookie)) {
                    $status->setMsg($output["actionPHPvoteDublicate"]);
                } else {
                    // Prevent double-vote
                    // Session prevents one-pageload-delay in output
                    array_push($cookie, $_GET['id']);
                    $cookie = implode(",", $cookie);
                    setcookie('votes', $cookie, time() + 3600);
                    $_SESSION['votes'] = $cookie;
                    
                    // Vote
                    $sql = "SELECT votes, title FROM wishlist WHERE id LIKE '".strip_tags($_GET['id'])."';";
                    $data = $db->query($sql);
                    $votes = $data->fetch_assoc();
                    
                    $myvote = $votes["votes"] + 1;

                    $sql = "UPDATE wishlist SET votes = ".$myvote." WHERE id LIKE '".strip_tags($_GET['id'])."';";
                    $db->query($sql);

                    // Output status
                    $status->setMsg($output["actionPHPvoteSuccess"]);
                }
            } else {
                $status->setMsg($output["actionPHPcookieIssue"]);
            }
        break;

        case 'allowcookies':
            setcookie('allowCookies', "true", time() + 3600);
            header('Location: index.php');
        break;

        // Restricted actions
        case 'resetwishlist':
            if ($_SESSION['backend']) {
                if (!isset($_GET['confirm'])) {
                    $status->setMsg($output["actionPHPresetWishlist"]);
                    $status->setMsg("<a href='backend.php?do=resetwishlist&confirm=true' class='btnRefresh'>".$output['yes']."</a>");
                    $status->setMsg("<a href='backend.php' class='btnDanger'>".$output['no']."</a>");
                } else {
                    // Delete song from wishlist
                    $db->query("DELETE FROM wishlist;");

                    // Output status
                    $status->setMsg($output["actionPHPresetWishlistSuccess"]);
                }
            }
        break;

        case 'resetsetlist':
            if ($_SESSION['backend']) {
                if (!isset($_GET['confirm'])) {
                    $status->setMsg($output["actionPHPresetSetlist"]);
                    $status->setMsg("<a href='setlist.php?do=resetsetlist&confirm=true' class='btnRefresh'>".$output['yes']."</a>");
                    $status->setMsg("<a href='setlist.php' class='btnDanger'>".$output['no']."</a>");
                } else {
                    // Delete song from wishlist
                    $db->query("DELETE FROM setlist;");

                    $db->query("ALTER TABLE setlist AUTO_INCREMENT = 1");

                    // Output status
                    $status->setMsg($output["actionPHPresetSetlistSuccess"]);
                }
            }
        break;

        case 'reset':
            if ($_SESSION['backend']) {
                if (!isset($_GET['confirm'])) {
                    $status->setMsg($output['actionPHPreset']);
                    $status->setMsg("<a href='backend.php?do=reset&confirm=true' class='btnRefresh'>".$output['yes']."</a>");
                    $status->setMsg("<a href='backend.php' class='btnDanger'>".$output['no']."</a>");
                } else {
                    // Empty playlist and wishlist
                    $db->query("DELETE FROM playlist;");
                    $db->query("DELETE FROM wishlist;");

                    // Reset play state on setlist
                    $db->query("UPDATE setlist SET played = false");

                    // Reset song counter / mysql primary key
                    $db->query("ALTER TABLE playlist AUTO_INCREMENT = 1");
                    $db->query("ALTER TABLE wishlist AUTO_INCREMENT = 1");
                    
                    // Remove export files
                    unlink("export.csv");
                    unlink("export_cust.csv");
                    
                    // Output status
                    $status->setMsg($output['actionPHPresetSuccess']);
                }
            }
        break;

        case 'add':
            if ($_SESSION['backend']) {
                // Insert song into playlist
                $sql = 'INSERT INTO playlist VALUES (
                    NULL,
                    "'.ucwords(strip_tags($_POST['title'])).'",
                    "'.ucwords(strip_tags($_POST['artist'])).'",
                    NULL,
                    0)';
                $db->query($sql);

                $latest = $db->insert_id;

                // Output status
                $status->setMsg($output['actionPHPadd']);
            }
        break;

        case 'remove':
            if ($_SESSION['backend']) {
                // Remove song from playlist
                $sql = "DELETE FROM playlist WHERE id LIKE '".strip_tags($_GET['id'])."';";
                $db->query($sql);

                // Output status
                $status->setMsg($output['actionPHPremove']);
            }
        break;

        case 'removefromset':
            if ($_SESSION['backend']) {
                // Remove song from setlist
                $sql = "DELETE FROM setlist WHERE id LIKE '".strip_tags($_GET['id'])."';";
                $db->query($sql);

                // Output status
                $status->setMsg($output['actionPHPremove']);
            }
        break;

        case 'removefromset':
            if ($_SESSION['backend']) {
                // Remove song from setlist
                $sql = "DELETE FROM setlist WHERE id LIKE '".strip_tags($_GET['id'])."';";
                $db->query($sql);

                // Output status
                $status->setMsg("Song #".strip_tags($_GET['id'])." removed.");
            }
        break;

        case 'removewish':
            if ($_SESSION['backend']) {
                // Remove song from wishlist
                $sql = "DELETE FROM wishlist WHERE id LIKE '".strip_tags($_GET['id'])."';";
                $db->query($sql);

                // Output status
                $status->setMsg($output['actionPHPremove']);
            }
        break;

        case 'accept':
            if ($_SESSION['backend']) {
                // Accept song on wishlist
                $sql = "UPDATE wishlist SET accepted = true WHERE id LIKE '".strip_tags($_GET['id'])."';";
                $db->query($sql);

                // Output status
                $status->setMsg($output['actionPHPaccept']);
            }
        break;

        case 'decline':
            if ($_SESSION['backend']) {
                // Decline song on wishlist
                $sql = "UPDATE wishlist SET declined = true WHERE id LIKE '".strip_tags($_GET['id'])."';";
                $db->query($sql);

                // Output status
                $status->setMsg($output['actionPHPdeclined']);
            }
        break;

        case 'play':
            if ($_SESSION['backend']) {
                // Move song from wishlist to playlist
                $sql = "SELECT * FROM wishlist WHERE id LIKE '".strip_tags($_GET['id'])."';";
                $data = $db->query($sql);
                $song = $data->fetch_assoc();

                $sql = 'INSERT INTO playlist VALUES(
                    NULL,
                    "'.$song["title"].'",
                    "'.$song["artist"].'",
                    NULL,
                    1)';
                $db->query($sql);

                $latest = $db->insert_id;

                $sql = "DELETE FROM wishlist WHERE id LIKE '".strip_tags($_GET['id'])."';";
                $db->query($sql);

                // Output status
                $status->setMsg($output['actionPHPplay']);
            }
        break;

        case 'playfromset':
            if ($_SESSION['backend']) {
                // Move song from wishlist to playlist
                $sql = "SELECT * FROM setlist WHERE id LIKE '".strip_tags($_GET['id'])."';";
                $data = $db->query($sql);
                $song = $data->fetch_assoc();

                $sql = 'INSERT INTO playlist VALUES(
                    NULL,
                    "'.$song["title"].'",
                    "'.$song["artist"].'",
                    NULL,
                    0)';
                $db->query($sql);
                
                $latest = $db->insert_id;

                $sql = "UPDATE setlist SET played = 1 WHERE id LIKE '".strip_tags($_GET['id'])."';";
                $db->query($sql);


                // Output status
                $status->setMsg($output['actionPHPplayFromSet']);
            }
        break;

        case 'addsetlist':
            // Add new song to setlist
            // Check if song already has been added
            $sql = "SELECT title FROM setlist WHERE title LIKE '".ucwords(strip_tags($_POST['title']))."';";
            $data = $db->query($sql);

            if ($data->num_rows) {
                $status->setMsg($output["actionPHPaddsetlistAlreadyOnSetlist"]);
            } else {
                // Insert song into setlist
                $sql = 'INSERT INTO setlist VALUES (
                    NULL,
                    "'.ucwords(strip_tags($_POST['title'])).'",
                    "'.ucwords(strip_tags($_POST['artist'])).'",
                    0,
                    0);';
                $db->query($sql);
                $sort = $db->insert_id;
            
                $sql = "UPDATE setlist SET sort = ".$sort." WHERE id LIKE '".$sort."';";
                $db->query($sql);

                // Output status
                $status->setMsg($output['actionPHPaddsetlist']);
            }
        break;

        case 'moveToSet':
            // Move song from wishlist to setlist
            // Check if song already has been added
            $sql = "SELECT setlist.title FROM setlist JOIN wishlist ON wishlist.title = setlist.title WHERE wishlist.id = ".strip_tags($_GET['id']).";";
            $data = $db->query($sql);
            
            if ($data->num_rows) {
                $song = $data->fetch_assoc();
                $status->setMsg($output['actionPHPmovetoset']);
                $status->setMsg("<a href='setlist.php?do=removewish&id=".strip_tags($_GET['id'])."'>".$output['yes']."</a>");
            } else { 
                // Receive md3 Tags from wishlist song
                $sql = 'SELECT * FROM wishlist WHERE id = '.strip_tags($_GET['id']).';';
                $data = $db->query($sql);

                $song = $data->fetch_assoc();

                // Insert song into setlist
                $sql = 'INSERT INTO setlist VALUES (
                    NULL,
                    "'.$song["title"].'",
                    "'.$song["artist"].'",
                    0,
                    0);';
                $db->query($sql);
                $sort = $db->insert_id;
            
                $sql = "UPDATE setlist SET sort = ".$sort." WHERE id LIKE '".$sort."';";
                $db->query($sql);

                // Remove song from wishlist
                $sql = "DELETE FROM wishlist WHERE id LIKE '".strip_tags($_GET['id'])."';";
                $db->query($sql);

                // Output status
                $status->setMsg($output['actionPHPmovetosetSuccess']);
            }
        break;

        case 'playfromset':
            if ($_SESSION['backend']) {
                // Move song from wishlist to playlist
                $sql = "SELECT * FROM setlist WHERE id LIKE '".strip_tags($_GET['id'])."';";
                $data = $db->query($sql);
                $song = $data->fetch_assoc();

                $sql = 'INSERT INTO playlist VALUES(
                    NULL,
                    "'.$song["title"].'",
                    "'.$song["artist"].'",
                    NULL,
                    0)';
                $db->query($sql);
                
                $latest = $db->insert_id;

                $sql = "UPDATE setlist SET played = 1 WHERE id LIKE '".strip_tags($_GET['id'])."';";
                $db->query($sql);


                // Output status
                $status->setMsg("Song <i>".$song['title']."</i> copied to playlist.");
            }
        break;

        case 'addsetlist':
            // Check if song already has been added
            $sql = "SELECT title FROM setlist WHERE title LIKE '".ucwords(strip_tags($_POST['title']))."';";
            $data = $db->query($sql);

            if ($data->num_rows) {
                $status->setMsg("Sorry, the song <i>".ucwords(strip_tags($_POST['title']))."</i> is already on the setlist.");
            } else {
                // Insert song into setlist
                $sql = 'INSERT INTO setlist VALUES (
                    NULL,
                    "'.ucwords(strip_tags($_POST['title'])).'",
                    "'.ucwords(strip_tags($_POST['artist'])).'",
                    0,
                    0,
                    "'.strip_tags($_POST['comment']).'");';
                $db->query($sql);
                $sort = $db->insert_id;
            
                $sql = "UPDATE setlist SET sort = ".$sort." WHERE id LIKE '".$sort."';";
                $db->query($sql);

                // Output status
                $status->setMsg("Song <i>".ucwords(strip_tags($_POST['title']))."</i> added.");
            }
        break;

        case 'moveup': 
            // Move song one item upwards
            $sort = strip_tags($_GET['id']);
            $data = $db->query("SELECT * FROM setlist WHERE sort LIKE '".($sort + 1)."';");
            $count = $data->num_rows;
            
            if ($count) {
                $db->query("UPDATE setlist SET sort = 99999 WHERE sort LIKE '".($sort + 1)."';");
                $db->query("UPDATE setlist SET sort = ".($sort + 1)." WHERE sort LIKE '".($sort)."';");
                $db->query("UPDATE setlist SET sort = ".$sort." WHERE sort LIKE '99999';");
            } 
        break;

        case 'movedown': 
            // Move song one item upwards
            $sort = strip_tags($_GET['id']);
            $data = $db->query("SELECT * FROM setlist WHERE sort LIKE '".($sort - 1)."';");
            $count = $data->num_rows;

            if ($count) {
                $db->query("UPDATE setlist SET sort = 99999 WHERE sort LIKE '".($sort - 1)."';");
                $db->query("UPDATE setlist SET sort = ".($sort - 1)." WHERE sort LIKE '".($sort)."';");
                $db->query("UPDATE setlist SET sort = ".$sort." WHERE sort LIKE '99999';");
            } 
        break;
    }
}
