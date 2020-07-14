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
    
    public function setMsg($msg) {
        $this->msg .= $msg;
    }

    public function printMsg() {
        return $this->msg;
    }
}
