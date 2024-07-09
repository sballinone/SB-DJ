<?php

/* SB DJ 
 * Release 2024
 * Written by Saskia Brückner
 */

class CSong {
    // Song md3 tags
    private $id;
    private $title;
    private $artist;

    // Playlist tags
    private $timestamp;
    private $waswish;

    // Wishlist tags
    private $accepted;
    private $declined;
    private $votes;
    private $hostname;

    // Setlist tags
    private $comment;
    private $sort;
    private $played;

    function __construct($id, $title, $artist) {
        $this->id = $id;
        $this->title = $title;
        $this->artist = $artist;
    }

    public function setupForPlaylist($timestamp, $waswish) {
        $this->timestamp = $timestamp;
        $this->waswish = $waswish;
    }

    public function setupForWishlist($accepted, $declined, $votes, $hostname) {
        $this->accepted = $accepted;
        $this->declined = $declined;
        $this->votes = $votes;
        $this->hostname = $hostname;
    }

    public function setupForSetlist($comment, $sort, $played) {
        $this->comment = $comment;
        $this->sort = $sort;
        $this->played = $played;
    }

    public function returnPlaylist($showDeleteIcon = true, $latest = false) {

        $return = '<div class="item';
        // Check if song was on wishlist and add class 'wish'
        if ($this->waswish == true) {
            $return .= " wish";
        }
        if ($this->id == $latest) {
            $return .= " latestwish";
        }
        $return .= '">';
        $return .= '<div class="row">';
        $return .= '<div class="col-xs-2 col-sm-2 col-md-2 col-xl-2">';
        $return .= '<div class="box"><span class="timestamp">'.date('h:i a', strtotime($this->timestamp)).'</span></div></div>';
        $return .= '<div class="col-xs-5 col-sm-5 col-md-5 col-xl-5">';
        $return .= '<div class="box"><span class="title">'.$this->title.'</span></div></div>';
        $return .= '<div class="col-xs-4 col-sm-4 col-md-4 col-xl-4">';
        $return .= '<div class="box"><span class="artist">'.$this->artist.'</span></div></div>';
        $return .= '<div class="col-xs-1 col-sm-1 col-md-1 col-xl-1">';
        $return .= '<div class="box">';
        
        // Check if dj or guest
        if (isset($_SESSION['backend']) && $showDeleteIcon) {
            // Add remove button if dj
            $return .= '<div class="actions">';
            $return .= "<a href='backend.php?id=".$this->id."&do=remove' class='removeFromPlaylist'><i class='icofont-delete'></i></a>";
            $return .= '</div>';
        }
        $return .= '</div></div></div></div>';
        
        return $return;
    }

    public function returnWishlist($latestwish) {
        $return = '<div class="item ';
        
        // Check if song was declined or accepted and add corresponding class
        if ($this->declined == true) {
            $return .= " declined";
        }

        if ($this->accepted == true) {
            $return .= " accepted";
        }

        // Check if song is latest wish
        if ($this->id == $latestwish) {
            $return .= " latestwish";
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
        if (isset($_SESSION['backend'])) {
            $return .= preview($this->hostname, 15);
        }
        $return .= '</span></div></div>';
        $return .= '<div class="col-xs-3 col-sm-3 col-md-3 col-xl-3">';
        $return .= '<div class="box"><div class="actions">';

        // Check if dj or guest
        if (isset($_SESSION['backend'])) {

            // Check if song has been declined or accepted
            if ($this->declined != true && $this->accepted != true) {
                $return .= "<a href='backend.php?id=".$this->id."&do=accept' class='accept'><i class='icofont-check-circled'></i></a>";
                $return .= "<a href='backend.php?id=".$this->id."&do=decline' class='decline'><i class='icofont-close-circled'></i></a>";
                $return .= "<a href='backend.php?id=".$this->id."&do=removewish'><i class='icofont-minus-circle'></i></a>";
            }

            // If song has been accepted, add setlist and MoveToPlaylist button
            if ($this->accepted == true) {
                $return .= "<a href='setlist.php?id=".$this->id."&do=moveToSet' class='play'><i class='icofont-disc'></i></a>";
                $return .= "<a href='backend.php?id=".$this->id."&do=play' class='play'><i class='icofont-play-alt-2'></i></a>";
            }

        } else {

            // Check if song was your wish
            $cookie = explode(",", htmlspecialchars($_COOKIE['wishes']));
            if (in_array($this->id, $cookie)) {
                $return .= "<i class='icofont-heart yourwish'></i>";
            } else {

                // Check if song has been voted and add vote button
                $cookie = explode(",", htmlspecialchars($_COOKIE["votes"]));
                if (!in_array($this->id, $cookie) && !$this->declined) {
                    $return .= "<a href='index.php?id=".$this->id."&do=vote' class='vote'><i class='icofont-star'></i></a>";
                }
            
            }

        }

        $return .= '</div></div></div></div></div>';

        return $return;
    }

    public function returnSetlist($limit = false) {
        $return = '<div class="item';
        
        // Check if song has played state and add class 'played'
        if ($this->played == true) {
            $return .= " played";
        }
        
        if ($limit) {
            $return .= " setlist";
        }
        
        $return .= '">';
        $return .= '<div class="row">';

        if (!$limit) {
            $return .= '<div class="col-xs-1 col-sm-1 col-md-1 col-xl-1">';
            $return .= '<div class="box"><span class="timestamp">Song '.$this->sort.'</span></div></div>';
            $return .= '<div class="col-xs-4 col-sm-4 col-md-4 col-xl-4">';
            $return .= '<div class="box"><span class="title">'.$this->title.'</span></div></div>';
            $return .= '<div class="col-xs-3 col-sm-3 col-md-3 col-xl-3">';
            $return .= '<div class="box"><span class="artist">'.$this->artist.'</span></div></div>';
            $return .= '<div class="col-xs-4 col-sm-4 col-md-4 col-xl-4">';
        } else {
            $return .= '<div class="col-xs-2 col-sm-2 col-md-2 col-xl-2">';
            $return .= '<div class="box"><span class="timestamp">NEXT</span></div></div>';
            $return .= '<div class="col-xs-5 col-sm-5 col-md-5 col-xl-5">';
            $return .= '<div class="box"><span class="title">'.$this->title.'</span></div></div>';
            $return .= '<div class="col-xs-4 col-sm-4 col-md-4 col-xl-4">';
            $return .= '<div class="box"><span class="artist">'.$this->artist.'</span></div></div>';
            $return .= '<div class="col-xs-1 col-sm-1 col-md-1 col-xl-1">';
        }
        $return .= '<div class="box">';
        
        $return .= '<div class="actions">';
        $return .= "<a href='backend.php?id=".$this->id."&do=playfromset'><i class='icofont-play-alt-2'></i></a>";

        if (!$limit) {
            $return .= "<a href='setlist.php?id=".$this->sort."&do=movedown'><i class='icofont-curved-down'></i></a>";
            $return .= "<a href='setlist.php?id=".$this->sort."&do=moveup'><i class='icofont-curved-up'></i></a>";
            $return .= "<a href='setlist.php?id=".$this->id."&do=removefromset'><i class='icofont-delete'></i></a>";
        }
        $return .= '</div>';
        $return .= '</div></div></div></div>';
        
        return $return;
    }
}