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
        $return .= '<div class="row">';
        $return .= '<div class="col-xs-2 col-sm-2 col-md-2 col-xl-2">';
        $return .= '<div class="box"><span class="timestamp">'.date('h:i a',strtotime($this->timestamp)).'</span></div></div>';
        $return .= '<div class="col-xs-5 col-sm-5 col-md-5 col-xl-5">';
        $return .= '<div class="box"><span class="title">'.$this->title.'</span></div></div>';
        $return .= '<div class="col-xs-4 col-sm-4 col-md-4 col-xl-4">';
        $return .= '<div class="box"><span class="artist">'.$this->artist.'</span></div></div>';
        $return .= '<div class="col-xs-1 col-sm-1 col-md-1 col-xl-1">';
        $return .= '<div class="box">';
        
        // Check if dj or guest
        if($_SESSION['backend']) {
            // Add remove button if dj
            $return .= '<div class="actions">';
            $return .= "<a href='backend.php?id=".$this->id."&do=remove'><i class='icofont-delete'></i></a>";
            $return .= '</div>';
        }
        $return .= '</div></div></div></div>';
        
        return $return;
    }

    function returnWishlist() {
        $return = '<div class="item ';
        
        // Check if song was declined or accepted and add corresponding class
        if($this->declined == true) 
            $return .= " declined";
        if($this->accepted == true) 
            $return .= " accepted";
        
        // Check if song was your wish
        $cookie = explode(",", strip_tags($_SESSION['wishes']));
        if(in_array($this->id,$cookie)) {
            $return .= " yourwish";
        }
        
        $return .= '">';
        $return .= '<div class="row">';
        $return .= '<div class="col-xs-6 col-sm-6 col-md-6 col-xl-6">';
        $return .= '<div class="box"><span class="title">'.$this->title.'</span></div></div>';
        $return .= '<div class="col-xs-6 col-sm-6 col-md-6 col-xl-6">';
        $return .= '<div class="box"><span class="artist">'.$this->artist.'</span></div></div>';
        $return .= '</div><div class="row">';
        $return .= '<div class="col-xs-3 col-sm-3 col-md-3 col-xl-3">';
        $return .= '<div class="box"><span class="votes">'.$this->votes.' votes</span></div></div>';
        $return .= '<div class="col-xs-6 col-sm-6 col-md-6 col-xl-6">';
        $return .= '<div class="box"><span class="hostname">';
        if($_SESSION['backend'])
            $return .= preview($this->hostname,15);
        $return .= '</span></div></div>';
        $return .= '<div class="col-xs-3 col-sm-3 col-md-3 col-xl-3">';
        $return .= '<div class="box"><div class="actions">';
        
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
            $cookie = explode(",",strip_tags($_SESSION["votes"]));
            if(!in_array($this->id,$cookie)) {
                $return .= "<a href='index.php?id=".$this->id."&do=vote'><i class='icofont-star'></i></a>";
            }

        }

        $return .= '</div></div></div></div></div>';

        return $return;
    }
}