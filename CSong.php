<?php

/* SB DJ 
 * Release 2020.0
 * Written by Saskia Brückner
 */

class CSong {
    // Song md3 tags
    private $id;
    private $title;
    private $song;

    // Playlist tags
    private $timestamp;
    private $waswish;

    // Wishlist tags
    private $accepted;
    private $declined;
    private $votes;
    private $hostname;

    function __construct($id, $title, $artist) {
        $this->id = $id;
        $this->title = $title;
        $this->artist = $artist;
    }

    function setupForPlaylist($timestamp, $waswish) {
        $this->timestamp = $timestamp;
        $this->waswish = $waswish;
    }

    function setupForWishlist($accepted,$declined,$votes,$hostname) {
        $this->accepted = $accepted;
        $this->declined = $declined;
        $this->votes = $votes;
        $this->hostname = $hostname;
    }

    function returnPlaylist() {
        $return = '<div class="item';
        // Check if song was on wishlist and add class 'wish'
        if($this->waswish == true)
            $return .= " wish";
        $return .= '">';
        $return .= '<span class="title">'.$this->title.'</span>';
        $return .= '<span class="artist">'.$this->artist.'</span><br />';
        $return .= '<span class="timestamp">'.date('h:i a',strtotime($this->timestamp)).'</span>';
        
        // Check if dj or guest
        if($_SESSION['backend']) {
            // Add remove button if dj
            $return .= '<span class="actions">';
            $return .= "<a href='backend.php?id=".$this->id."&do=remove'><i class='icofont-delete'></i></a>";
            $return .= '</span>';
        }
        $return .= '</div>';

        return $return;
    }

    function returnWishlist() {
        $return = '<div class="item';
        
        // Check if song was declined or accepted and add corresponding class
        if($song["declined"] == true) 
            $return .= " declined";
        if($song["accepted"] == true) 
            $return .= " accepted";
        
        // Check if song was your wish
        $cookie = explode(",", $_SESSION['wishes']);
        if(in_array($this->id,$cookie)) {
            $return .= " yourwish";
        }
        
        $return .= '">';
        $return .= '<span class="title">'.$this->title.'</span>';
        $return .= '<span class="artist">'.$this->artist.'</span><br />';
        $return .= '<span class="votes">'.$this->votes.' votes</span>';
        $return .= '<span class="hostname">'.preview($this->hostname,15).'</span>';
        $return .= '<span class="actions">';
        
        // Check if dj or guest
        if($_SESSION['backend']) {

            // Check if song has been declined or accepted
            if($this->declined != true && $this->accepted != true) {
                $return .= "<a href='backend.php?id=".$this->id."&do=accept'><i class='icofont-check-circled'></i></a>";
                $return .= "<a href='backend.php?id=".$this->id."&do=decline'><i class='icofont-close-circled'></i></a>";
                $return .= "<a href='backend.php?id=".$this->id."&do=removewish'><i class='icofont-minus-circle'></i></a>";
            }

            // If song has been accepted, add MoveToPlaylist button
            if($this->accepted == true)
                $return .= "<a href='backend.php?id=".$this->id."&do=play'><i class='icofont-play-alt-2'></i></a>";

        } else {

            // Check if song has been voted and add vote button
            $cookie = explode(",",$_SESSION["votes"]);
            if(!in_array($this->id,$cookie)) {
                $return .= "<a href='index.php?id=".$this->id."&do=vote'><i class='icofont-star'></i></a>";
            }

        }

        $return .= '</span>';
        $return .= '</div>';

        return $return;
    }
}