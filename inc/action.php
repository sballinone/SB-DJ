<?php

/* SB DJ 
 * Release 2024
 * Written by Saskia Brückner
 */

if (isset($_GET['do'])) {
    switch (htmlspecialchars($_GET['do'])) {
        case 'addwish':
            if (strip_tags($_COOKIE['allowCookies']) || !$cookieconsent) {
                // Check if song already has been played
                $sql = "SELECT title FROM playlist WHERE title LIKE '".ucwords(htmlspecialchars($_POST['title']))."';";
                $data = $db->query($sql);

                if ($data->num_rows) {
                    $status->setMsg(sprintf(_("Sorry, the song <i>%s</i> already has been played."),ucwords(htmlspecialchars($_POST['title']))));
                } else {
                    // Check if song already has been wished
                    $sql = "SELECT title FROM wishlist WHERE title LIKE '".ucwords(htmlspecialchars($_POST['title']))."';";
                    $data = $db->query($sql);

                    if ($data->num_rows) {
                        $status->setMsg(sprintf(_("Sorry, the song <i>%s</i> is already on the wishlist."),ucwords(htmlspecialchars($_POST['title']))));
                    } else {

                        // Insert wish into wishlist
                        $sql = 'INSERT INTO wishlist VALUES (
                            NULL,
                            "'.ucwords(htmlspecialchars($_POST['title'])).'",
                            "'.ucwords(htmlspecialchars($_POST['artist'])).'",
                            0,
                            0,
                            1,
                            "'.gethostname().'");';
                        $db->query($sql);

                        // Set cookie and refresh session
                        $cookie = explode(",", $_COOKIE['wishes']);
                        array_push($cookie, $db->insert_id);
                        $cookie = implode(",", $cookie);
                        setcookie("wishes", $cookie, time() + 3600);
                        $_SESSION["wishes"] = $cookie;
                        
                        $latestwish = $db->insert_id;

                        // Output status
                        $status->setMsg(sprintf(_("Your wish <i>%s</i> has been added."),ucwords(htmlspecialchars($_POST['title']))));

                    }
                }
            } else {
                $status->setMsg(_("Sorry, you need to allow cookies. <a href='javascript:allowcookies()'>Allow cookies</a>"));
            }
        break;

        case 'export':
            // Check if export is allowed or if dj
            if (isset($_SESSION['backend']) || $export) {

                // Select the songs to export
                $sql = "SELECT * FROM playlist ORDER BY id DESC;";
                $data = $db->query($sql);

                // Check if dj or guest and set filename
                $filename;
                if (isset($_SESSION['backend'])) {
                    $filename = "export.csv";
                    $status->setMsg(_("Playlist successfully exported. <a href='export.csv' target='_blank' style='color: #000'>Open CSV</a>"));
                } else {
                    $filename = "export_cust.csv";
                    $status->setMsg(_("Playlist successfully exported. <a href='export_cust.csv' target='_blank' style='color: #000'>Open CSV</a>"));
                }

                // Write CSV file
                $txt = fopen($filename, "w");
                fwrite($txt, 'ID;Timestamp;Artist;Title;From Wishlist'.PHP_EOL);
                while($song = $data->fetch_assoc()) {
                    $csvline = $song["id"].";".date('Y.m.d h:i:s a', strtotime($song["timestamp"])).';'.$song["artist"].';'.$song["title"].';'.$song["waswish"].PHP_EOL;
                    fwrite($txt, $csvline);
                }
                fclose($txt);
            }
        break;

        case 'import':
            if (!isset($_GET['import'])) {
                $status->setMsg('<form action="backend.php?do=import&import=true" method="POST" enctype="multipart/form-data">');
                $status->setMsg(_("CSV file (Djay formatted): "));
                $status->setMsg('<br /><input type="file" name="importfile" id="importfile">&nbsp;&nbsp;&nbsp;<input type="submit" value="'._("Import").'" name="submit"></form>');
            } else {
                // Upload the file (outsourced for improved readability)
                include('inc/upload.php');

                $txt = fopen($target_file, "r");
                
                // Skip the first line (titles and table header)
                $data = fgetcsv($txt);
                
                // Do the import...
                while (!feof($txt)) {
                    $data = fgetcsv($txt);

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
                fclose($txt);

                // Remove the file
                unlink($target_file);
            }
        break;

        case 'vote':
            if ($_COOKIE['allowCookies'] || !$cookieconsent) {
                // Check if already voted
                $cookie = explode(",", $_COOKIE['votes']);

                if (in_array($_GET['id'], $cookie)) {
                    $status->setMsg(_("Oh no! You already voted for this song."));
                } else {
                    // Prevent double-vote
                    // Session prevents one-pageload-delay in output
                    array_push($cookie, $_GET['id']);
                    $cookie = implode(",", $cookie);
                    setcookie('votes', $cookie, time() + 3600);
                    $_SESSION['votes'] = $cookie;
                    
                    // Vote
                    $sql = "SELECT votes, title FROM wishlist WHERE id LIKE '".htmlspecialchars($_GET['id'])."';";
                    $data = $db->query($sql);
                    $votes = $data->fetch_assoc();
                    
                    $myvote = $votes["votes"] + 1;

                    $sql = "UPDATE wishlist SET votes = ".$myvote." WHERE id LIKE '".htmlspecialchars($_GET['id'])."';";
                    $db->query($sql);

                    // Output status
                    $status->setMsg(sprintf(_("Yeah! You voted for <i>%s</i>."),$votes["title"]));
                }
            } else {
                $status->setMsg(_("Sorry, you need to allow cookies. <a href='javascript:allowcookies()'>Allow cookies</a>"));
            }
        break;

        case 'allowcookies':
            setcookie('allowCookies', "true", time() + 3600);
            setcookie("wishes", "NULL", time() + 3600);
            setcookie("votes", "NULL", time() + 3600);
            header('Location: index.php');
        break;

        // Restricted actions
        case 'resetwishlist':
            if (isset($_SESSION['backend'])) {
                if (!isset($_GET['confirm'])) {
                    $status->setMsg(_("Reset wishlist?"));
                    $status->setMsg(" <a href='backend.php?do=resetwishlist&confirm=true' class='btnRefresh'>"._("Yes")."</a>");
                    $status->setMsg("<a href='backend.php' class='btnDanger'>"._("No")."</a>");
                } else {
                    // Delete song from wishlist
                    $db->query("DELETE FROM wishlist;");

                    // Output status
                    $status->setMsg(_("Wishlist reset successful."));
                }
            }
        break;

        case 'resetsetlist':
            if (isset($_SESSION['backend'])) {
                if (!isset($_GET['confirm'])) {
                    $status->setMsg(_("Reset setlist?"));
                    $status->setMsg(" <a href='setlist.php?do=resetsetlist&confirm=true' class='btnRefresh'>"._("Yes")."</a>");
                    $status->setMsg("<a href='setlist.php' class='btnDanger'>"._("No")."</a>");
                } else {
                    // Delete song from wishlist
                    $db->query("DELETE FROM setlist;");

                    $db->query("ALTER TABLE setlist AUTO_INCREMENT = 1");

                    // Output status
                    $status->setMsg(_("Setlist reset successful."));
                }
            }
        break;

        case 'reset':
            if (isset($_SESSION['backend'])) {
                if (!isset($_GET['confirm'])) {
                    $status->setMsg(_("Reset all? This clears the wishlist and the playlist."));
                    $status->setMsg(" <a href='backend.php?do=reset&confirm=true' class='btnRefresh'>"._("Yes")."</a>");
                    $status->setMsg("<a href='backend.php' class='btnDanger'>"._("No")."</a>");
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
                    $status->setMsg(_("Reset successful."));
                }
            }
        break;

        case 'add':
            if (isset($_SESSION['backend'])) {
                // Insert song into playlist
                $sql = 'INSERT INTO playlist VALUES (
                    NULL,
                    "'.ucwords(htmlspecialchars($_POST['title'])).'",
                    "'.ucwords(htmlspecialchars($_POST['artist'])).'",
                    "'.date('Y-m-d H:i:s').'",
                    0)';
                $db->query($sql);

                $latest = $db->insert_id;

                // Output status
                $status->setMsg(sprintf(_("Song <i>%s</i> added."),ucwords(htmlspecialchars($_POST['title']))));
            }
        break;

        case 'remove':
            if (isset($_SESSION['backend'])) {
                // Remove song from playlist
                $sql = "DELETE FROM playlist WHERE id LIKE '".htmlspecialchars($_GET['id'])."';";
                $db->query($sql);

                // Output status
                $status->setMsg(sprintf(_("Song #%s removed."),htmlspecialchars($_GET['id'])));
            }
        break;

        case 'removefromset':
            if (isset($_SESSION['backend'])) {
                // Remove song from setlist
                $sql = "DELETE FROM setlist WHERE id LIKE '".htmlspecialchars($_GET['id'])."';";
                $db->query($sql);

                // Output status
                $status->setMsg(sprintf(_("Song #%s removed."),htmlspecialchars($_GET['id'])));
            }
        break;

        case 'removefromset':
            if (isset($_SESSION['backend'])) {
                // Remove song from setlist
                $sql = "DELETE FROM setlist WHERE id LIKE '".htmlspecialchars($_GET['id'])."';";
                $db->query($sql);

                // Output status
                $status->setMsg("Song #".htmlspecialchars($_GET['id'])." removed.");
            }
        break;

        case 'removewish':
            if (isset($_SESSION['backend'])) {
                // Remove song from wishlist
                $sql = "DELETE FROM wishlist WHERE id LIKE '".htmlspecialchars($_GET['id'])."';";
                $db->query($sql);

                // Output status
                $status->setMsg(sprintf(_("Song #%s removed."),htmlspecialchars($_GET['id'])));
            }
        break;

        case 'accept':
            if (isset($_SESSION['backend'])) {
                // Accept song on wishlist
                $sql = "UPDATE wishlist SET accepted = true WHERE id LIKE '".htmlspecialchars($_GET['id'])."';";
                $db->query($sql);

                // Output status
                $status->setMsg(sprintf(_("Song #%s accepted."),htmlspecialchars($_GET['id'])));
            }
        break;

        case 'decline':
            if (isset($_SESSION['backend'])) {
                // Decline song on wishlist
                $sql = "UPDATE wishlist SET declined = true WHERE id LIKE '".htmlspecialchars($_GET['id'])."';";
                $db->query($sql);

                // Output status
                $status->setMsg(sprintf(_("Song #%s declined."),htmlspecialchars($_GET['id'])));
            }
        break;

        case 'play':
            if (isset($_SESSION['backend'])) {
                // Move song from wishlist to playlist
                $sql = "SELECT * FROM wishlist WHERE id LIKE '".htmlspecialchars($_GET['id'])."';";
                $data = $db->query($sql);
                $song = $data->fetch_assoc();

                $sql = 'INSERT INTO playlist VALUES(
                    NULL,
                    "'.$song["title"].'",
                    "'.$song["artist"].'",
                    "'.date('Y-m-d H:i:s').'",
                    1)';
                $db->query($sql);

                $latest = $db->insert_id;

                $sql = "DELETE FROM wishlist WHERE id LIKE '".htmlspecialchars($_GET['id'])."';";
                $db->query($sql);

                // Output status
                $status->setMsg(sprintf(_("Song <i>%s</i> moved to playlist."),$song['title']));
            }
        break;

        case 'playfromset':
            if (isset($_SESSION['backend'])) {
                // Move song from wishlist to playlist
                $sql = "SELECT * FROM setlist WHERE id LIKE '".htmlspecialchars($_GET['id'])."';";
                $data = $db->query($sql);
                $song = $data->fetch_assoc();

                $sql = 'INSERT INTO playlist VALUES(
                    NULL,
                    "'.$song["title"].'",
                    "'.$song["artist"].'",
                    "'.date('Y-m-d H:i:s').'",
                    0)';
                $db->query($sql);
                
                $latest = $db->insert_id;

                $sql = "UPDATE setlist SET played = 1 WHERE id LIKE '".htmlspecialchars($_GET['id'])."';";
                $db->query($sql);


                // Output status
                $status->setMsg(sprintf(_("Song <i>%s</i> copied to playlist."),$song['title']));
            }
        break;

        case 'addsetlist':
            // Add new song to setlist
            // Check if song already has been added
            $sql = "SELECT title FROM setlist WHERE title LIKE '".ucwords(htmlspecialchars($_POST['title']))."';";
            $data = $db->query($sql);

            if ($data->num_rows) {
                $status->setMsg(sprintf(_("Sorry, the song <i>%s</i> is already on the setlist."),ucwords(htmlspecialchars($_POST['title']))));
            } else {
                // Insert song into setlist
                $sql = 'INSERT INTO setlist VALUES (
                    NULL,
                    "'.ucwords(htmlspecialchars($_POST['title'])).'",
                    "'.ucwords(htmlspecialchars($_POST['artist'])).'",
                    0,
                    0);';
                $db->query($sql);
                $sort = $db->insert_id;
            
                $sql = "UPDATE setlist SET sort = ".$sort." WHERE id LIKE '".$sort."';";
                $db->query($sql);

                // Output status
                $status->setMsg(sprintf(_("Song <i>%s</i> added."),ucwords(htmlspecialchars($_POST['title']))));
            }
        break;

        case 'moveToSet':
            // Move song from wishlist to setlist
            // Check if song already has been added
            $sql = "SELECT setlist.title FROM setlist JOIN wishlist ON wishlist.title = setlist.title WHERE wishlist.id = ".htmlspecialchars($_GET['id']).";";
            $data = $db->query($sql);
            
            if ($data->num_rows) {
                $song = $data->fetch_assoc();
                $status->setMsg(sprintf(_("Sorry, the song <i>%s</i> is already on the setlist. Remove wish?"),ucwords(htmlspecialchars($song['title']))));
                $status->setMsg(" <a href='setlist.php?do=removewish&id=".htmlspecialchars($_GET['id'])."'>"._("Yes")."</a>");
            } else { 
                // Receive md3 Tags from wishlist song
                $sql = 'SELECT * FROM wishlist WHERE id = '.htmlspecialchars($_GET['id']).';';
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
                $sql = "DELETE FROM wishlist WHERE id LIKE '".htmlspecialchars($_GET['id'])."';";
                $db->query($sql);

                // Output status
                $status->setMsg(sprintf(_("Song <i>%s</i> moved."),$song['title']));
            }
        break;

        case 'playfromset':
            if (isset($_SESSION['backend'])) {
                // Move song from wishlist to playlist
                $sql = "SELECT * FROM setlist WHERE id LIKE '".htmlspecialchars($_GET['id'])."';";
                $data = $db->query($sql);
                $song = $data->fetch_assoc();

                $sql = 'INSERT INTO playlist VALUES(
                    NULL,
                    "'.$song["title"].'",
                    "'.$song["artist"].'",
                    "'.date('Y-m-d H:i:s').'",
                    0)';
                $db->query($sql);
                
                $latest = $db->insert_id;

                $sql = "UPDATE setlist SET played = 1 WHERE id LIKE '".htmlspecialchars($_GET['id'])."';";
                $db->query($sql);


                // Output status
                $status->setMsg("Song <i>".$song['title']."</i> copied to playlist.");
            }
        break;

        case 'addsetlist':
            // Check if song already has been added
            $sql = "SELECT title FROM setlist WHERE title LIKE '".ucwords(htmlspecialchars($_POST['title']))."';";
            $data = $db->query($sql);

            if ($data->num_rows) {
                $status->setMsg("Sorry, the song <i>".ucwords(htmlspecialchars($_POST['title']))."</i> is already on the setlist.");
            } else {
                // Insert song into setlist
                $sql = 'INSERT INTO setlist VALUES (
                    NULL,
                    "'.ucwords(htmlspecialchars($_POST['title'])).'",
                    "'.ucwords(htmlspecialchars($_POST['artist'])).'",
                    0,
                    0,
                    "'.htmlspecialchars($_POST['comment']).'");';
                $db->query($sql);
                $sort = $db->insert_id;
            
                $sql = "UPDATE setlist SET sort = ".$sort." WHERE id LIKE '".$sort."';";
                $db->query($sql);

                // Output status
                $status->setMsg("Song <i>".ucwords(htmlspecialchars($_POST['title']))."</i> added.");
            }
        break;

        case 'moveup': 
            // Move song one item upwards
            $sort = htmlspecialchars($_GET['id']);
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
            $sort = htmlspecialchars($_GET['id']);
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
