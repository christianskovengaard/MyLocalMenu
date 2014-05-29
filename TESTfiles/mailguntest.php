<html>
    <head></head>
    <body>
        <form method="POST" action="">
            <input type="text" placeholder="Email emne" name="subject">
            <input type="text" placeholder="Email tekst" name="body">
            <input type="submit" value="Send mail" name="sendmail">
        </form>
    </body>
</html>


<?php




# Include the Autoloader (see "Libraries" for install instructions)
require_once 'Classes/mailgun/vendor/autoload.php';
use Mailgun\Mailgun;




if(isset($_POST['sendmail'])) {
    
    
    # Instantiate the client.
        $mgClient = new Mailgun('key-88g6sqd16pjmmv76ysapw2yf3oqi1rp8');
        $domain = "mylocalcafe.dk";
    
    $sFrom = 'Support <support@mylocalcafe.dk>';
    $sTo = 'christianskovengaard@gmail.com';
    $sSubject = "Test mail";
    $sMessage = "her er noget tekst";


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

}