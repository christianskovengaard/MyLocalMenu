<?php

# Include the Autoloader (see "Libraries" for install instructions)
//require_once '../Classes/mailgun/vendor/autoload.php';
use Mailgun\Mailgun;


class EmailController
{
    public function __construct() {
        ;
    }
    
    public function SendEmail ($sTo,$sFrom,$sSubject,$sMessage)
    {
        # Instantiate the client.
        $mgClient = new Mailgun('key-88g6sqd16pjmmv76ysapw2yf3oqi1rp8');
        $domain = "mylocalcafe.dk";
        
        $sFrom = 'Support <support@mylocalcafe.dk>';

        # Make the call to the client.
        $result = $mgClient->sendMessage($domain,
                              array('from'    => $sFrom,
                                'to'      => $sTo,
                                'subject' => $sSubject,
                                'text'    => $sMessage,
                                'html'    => '<html>'.$sMessage.'</html>',
                                'h:charset' => 'utf-8',
                                'h:Reply-To' => 'info@mylocalcafe.dk',
                                'h:Return-Path' => 'info@mylocalcafe.dk')
                );
        
        /*
        $sReturnPath = 'info@mylocalcafe.dk';
        $sReplayTo = 'info@mylocalcafe.dk';

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: MyLocalCafe <'.$sFrom. ">\r\n";
        $headers .= 'Return-Path: MyLocalCafe<'.$sReturnPath. ">\r\n";
        $headers .= 'Reply-To: MyLocalCafe <'.$sReplayTo."> \r\n";
       
        mail($sTo,$sSubject,$sMessage, $headers," -f ".$sReturnPath);*/
    }

        public function __destruct() {
        ;
    }
}
?>
