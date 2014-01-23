<?php

class EmailController
{
    public function __construct() {
        ;
    }
    
    public function SendEmail ($sTo,$sFrom,$sSubject,$sMessage)
    {
        $sReturnPath = 'info@mylocalcafe.dk';
        $sReplayTo = 'info@mylocalcafe.dk';

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: MyLocalCafe <'.$sFrom. ">\r\n";
        $headers .= 'Return-Path: MyLocalCafe<'.$sReturnPath. ">\r\n";
        $headers .= 'Reply-To: MyLocalCafe <'.$sReplayTo."> \r\n";
       
        mail($sTo,$sSubject,$sMessage, $headers," -f ".$sReturnPath);
    }

        public function __destruct() {
        ;
    }
}
?>
