<?php

/* SB DJ 
 * Release 2020.0
 * Written by Saskia Brückner
 */

if(isset($_GET['do'])) {
    switch(strip_tags($_GET['do'])) {
        case 'addwish':
            // Check if song already has been played
            $sql = "SELECT title FROM playlist WHERE title LIKE '".ucwords(strip_tags($_POST['title']))."';";
            $data = $db->query($sql);

            if($data->num_rows) {
                $status->setMsg("Sorry, the song <i>".ucwords(strip_tags($_POST['title']))."</i> already has been played.");
            } else {
                // Check if song already has been wished
                $sql = "SELECT title FROM wishlist WHERE title LIKE '".ucwords(strip_tags($_POST['title']))."';";
                $data = $db->query($sql);

                if($data->num_rows) {
                    $status->setMsg("Sorry, the song <i>".ucwords(strip_tags($_POST['title']))."</i> is already on the wishlist.");
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
                    $cookie = explode(",",strip_tags($_COOKIE['wishes']));
                    array_push($cookie,$db->insert_id);
                    $cookie = implode(",", $cookie);
                    setcookie("wishes",$cookie,time()+3600);
                    $_SESSION["wishes"] = $cookie;
                    
                    $latestwish = $db->insert_id;

                    // Output status
                    $status->setMsg("Wish <i>".ucwords(strip_tags($_POST['title']))."</i> added.");

                }
            }
        break;

        case 'export':
            // Check if export is allowed or if dj
            if($_SESSION['backend'] || $export) {

                // Select the songs to export
                $sql = "SELECT * FROM playlist ORDER BY id DESC;";
                $data = $db->query($sql);

                // Check if dj or guest and set filename
                $filename;
                if($_SESSION['backend']) {
                    $filename = "export.csv";
                } else {
                    $filename = "export_cust.csv";
                }

                // Write CSV file
                $txt = fopen($filename,"w");
                fwrite(/** @scrutinizer ignore-type */ $txt,'Timestamp,Artist,Title,From Wishlist'.PHP_EOL);
                while($song = $data->fetch_assoc()) {
                    $csvline = date('d.m.Y h:i a', strtotime($song["timestamp"])).','.$song["artist"].','.$song["title"].','.$song["waswish"].PHP_EOL;
                    fwrite($txt,$csvline);
                }
                fclose(/** @scrutinizer ignore-type */$txt);

                // Output status
                $status->setMsg("Playlist successfully exported. <a href='export.csv' target='_blank'>Open CSV</a>");
            }
        break;

        case 'vote':
            // Check if already voted
            $cookie = explode(",", strip_tags($_COOKIE['votes']));

            if(in_array($_GET['id'], $cookie)) {
                $status->setMsg("Oh no! You already voted for <i>".$votes["title"]."</i>.");
            } else {
                // Prevent double-vote
                // Session prevents one-pageload-delay in output
                array_push($cookie,$_GET['id']);
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
                $status->setMsg("Yeah! You voted for <i>".$votes["title"]."</i>.");
            }
        break;

        // Restricted actions
        case 'resetwishlist':
            if($_SESSION['backend']) {
                // Delete song from wishlist
                $db->query("DELETE FROM wishlist;");

                // Output status
                $status->setMsg("Wishlist reset successful.");
            }
        break;

        case 'reset':
            if($_SESSION['backend']) {
                // Empty playlist and wishlist
                $db->query("DELETE FROM playlist;");
                $db->query("DELETE FROM wishlist;");

                // Reset song counter / mysql primary key
                $db->query("ALTER TABLE playlist AUTO_INCREMENT = 1");
                $db->query("ALTER TABLE wishlist AUTO_INCREMENT = 1");
                
                // Remove export files
                unlink("export.csv");
                unlink("export_cust.csv");
                
                // Output status
                $status->setMsg("Reset successful.");
            }
        break;

        case 'add':
            if($_SESSION['backend']) {
                // Insert song into playlist
                $sql = 'INSERT INTO playlist VALUES (
                    NULL,
                    "'.ucwords(strip_tags($_POST['title'])).'",
                    "'.ucwords(strip_tags($_POST['artist'])).'",
                    NULL,
                    0)';
                $db->query($sql);

                // Output status
                $status->setMsg("Song <i>".ucwords(strip_tags($_POST['title']))."</i> added.");
            }
        break;

        case 'remove':
            if($_SESSION['backend']) {
                // Remove song from playlist
                $sql = "DELETE FROM playlist WHERE id LIKE '".strip_tags($_GET['id'])."';";
                $db->query($sql);

                // Output status
                $status->setMsg("Song #".strip_tags($_GET['id'])." removed.");
            }
        break;

        case 'removewish':
            if($_SESSION['backend']) {
                // Remove song from wishlist
                $sql = "DELETE FROM wishlist WHERE id LIKE '".strip_tags($_GET['id'])."';";
                $db->query($sql);

                // Output status
                $status->setMsg("Wish #".strip_tags($_GET['id'])." removed.");
            }
        break;

        case 'accept':
            if($_SESSION['backend']) {
                // Accept song on wishlist
                $sql = "UPDATE wishlist SET accepted = true WHERE id LIKE '".strip_tags($_GET['id'])."';";
                $db->query($sql);

                // Output status
                $status->setMsg("Song #".strip_tags($_GET['id'])." accepted.");
            }
        break;

        case 'decline':
            if($_SESSION['backend']) {
                // Decline song on wishlist
                $sql = "UPDATE wishlist SET declined = true WHERE id LIKE '".strip_tags($_GET['id'])."';";
                $db->query($sql);

                // Output status
                $status->setMsg("Song #".strip_tags($_GET['id'])." declined.");
            }
        break;

        case 'play':
            if($_SESSION['backend']) {
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

                $sql = "DELETE FROM wishlist WHERE id LIKE '".strip_tags($_GET['id'])."';";
                $db->query($sql);

                // Output status
                $status->setMsg("Song <i>".$song['title']."</i> moved to playlist.");
            }
        break;
    }
}
