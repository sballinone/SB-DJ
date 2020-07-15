<?php

/* SB DJ 
 * Release 2020.0
 * Written by Saskia Brückner
 */

function preview($text, $limit) {
    // Remove tags
    $text = preg_replace('/\[\/?(?:b|i|u|s|center|quote|url|ul|ol|list|li|\*|code|table|tr|th|td|youtube|gvideo|(?:(?:size|color|quote|name|url|img)[^\]]*))\]/', '', $text);

    // Shorten string if longer than limit
    if (strlen($text) > $limit) return substr($text, 0, $limit) . "...";

    return $text;
}

function playlist($db, $showDeleteIcon = true, $latest = false) {
    $playlist = array();
    $data = $db->query("SELECT * FROM playlist ORDER BY id DESC;");
    
    while($song = $data->fetch_assoc()) {
        $item = new CSong($song["id"],$song["title"],$song["artist"]);
        $item->setupForPlaylist($song["timestamp"],$song["waswish"]);
        array_push($playlist, $item);
    }
    
    foreach ($playlist as $song) {
        echo $song->returnPlaylist($showDeleteIcon, $latest);
    }
}

function wishlist($db, $latestwish) {
    $wishlist = array();

    $data = $db->query("SELECT * FROM wishlist ORDER BY accepted DESC, declined, votes DESC;");
    
    while($song = $data->fetch_assoc()) {
        $item = new CSong($song["id"],$song["title"],$song["artist"]);
        $item->setupForWishlist($song["accepted"], $song["declined"], $song["votes"], $song["hostname"]);
        array_push($wishlist, $item);
    }
    
    foreach ($wishlist as $song) {
        echo $song->returnWishlist($latestwish);
    }
}

function setlist($db, $limit = false) {
    
    $setlist = array();
    if(!$limit) {
        $data = $db->query("SELECT * FROM setlist ORDER BY sort DESC;");
    } else {
        $data = $db->query("SELECT * FROM setlist WHERE played LIKE '0' ORDER BY sort ASC LIMIT 1;");
    }
    
    while($song = $data->fetch_assoc()) {
        $item = new CSong($song["id"],$song["title"],$song["artist"]);
        $item->setupForSetlist($song["comment"],$song["sort"],$song["played"]);
        array_push($setlist, $item);
    }
    
    foreach ($setlist as $song) {
        echo $song->returnSetlist($limit);
   }
}
