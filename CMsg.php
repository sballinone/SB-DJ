<?php

/* SB DJ 
 * Release 2020.0
 * Written by Saskia Brückner
 */

class CMsg {
    private $msg;

    function __construct() {
        $this->msg = "";
    }
    
    function setMsg($msg) {
        $this->msg .= $msg;
    }

    function printMsg() {
        return $this->msg;
    }
}
