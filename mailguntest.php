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
    
    $subject = $_POST['subject'];
    $body = $_POST['body'];
    
    # Make the call to the client.
$result = $mgClient->sendMessage($domain,
                      array('from'    => 'MyLocalCafé <support@mylocalcafe.dk>',
                            'to'      => 'christianskovengaard@gmail.comk',
                            'cc'      => 'christianskovengaard@gmail.com',
                            'bcc'     => 'christianskovengaard@gmail.com',
                            'subject' => $subject,
                            'text'    => $body,
                            'html'    => '<html>'.$body.'</html>'),
                      array('attachment' => array('@/home/c5/C5/2/SKSReports/SKSRapport_Jarlkrone_02-03-2013.pdf')));

}