<?php


class StampcardController
{
    
    private $conPDO;
    private $oSecurityController;
    
    public function __construct() {
        require_once 'DatabaseController.php';
        $oDatabase = new DatabaseController();
        $this->conPDO = $oDatabase->ConnectToDatabase();
        
        require_once 'SecurityController.php';
        $this->oSecurityController = new SecurityController();
    }
    
    
    public function CreateStampcard($iFK_iRestuarentInfoId) {
        
        $sQuery = $this->conPDO->prepare("INSERT INTO stampcard (iStampcardMaxStamps,iFK_iRestuarentInfoId) VALUES (:iStampcardMaxStamps,:iFK_iRestuarentInfoId)");
        $sQuery->bindValue(":iStampcardMaxStamps", '5');
        $sQuery->bindValue(":iFK_iRestuarentInfoId", $iFK_iRestuarentInfoId);
        
        try {
                $sQuery->execute();
                return true;
        }
        catch(PDOException $e)
        {
            die($e->getMessage());
        }       
    }
    
    
    public function SaveStampcard() {
        
        $oStampcard = array(
                'sFunction' => 'GetStampcard',
                'result' => false
            );
        
        if(isset($_GET['sJSONStampcard']))
        {
            $sJSONStampcard = $_GET['sJSONStampcard'];
            $oJSONStampcard = json_decode($sJSONStampcard);
        
            //Check if session is started
            if(!isset($_SESSION['sec_session_id']))
            { 
                $this->oSecurityController->sec_session_start();
            }

            //Check if user is logged in
            if($this->oSecurityController->login_check() == true)
            {
                $sQuery = $this->conPDO->prepare("SELECT iRestuarentInfoId FROM restuarentinfo 
                                                    INNER JOIN users
                                                    ON users.sUsername = :sUsername
                                                    INNER JOIN company
                                                    ON company.iCompanyId = users.iFK_iCompanyId");
                $sQuery->bindValue(':sUsername', $_SESSION['username']);
                $sQuery->execute();
                $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
                $iRestuarentInfoId = $aResult['iRestuarentInfoId'];
                
                //Check if stamcard all ready exsists
                $sQuery = $this->conPDO->prepare("SELECT COUNT(*) AS number FROM stampcard WHERE iFK_iRestuarentInfoId = :iFK_iRestuarentInfoId");
                $sQuery->bindValue(':iFK_iRestuarentInfoId', $iRestuarentInfoId);
                $sQuery->execute();
                $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
                if($aResult['number'] == 1) {
                    $sQuery = $this->conPDO->prepare("UPDATE stampcard SET iStampcardMaxStamps = :iStampcardMaxStamps, iFK_iRestuarentInfoId = :iFK_iRestuarentInfoId");
                } else {
                    //Create new stampcard
                    $sQuery = $this->conPDO->prepare("INSERT INTO stampcard (iStampcardMaxStamps,iFK_iRestuarentInfoId) VALUES (:iStampcardMaxStamps,:iFK_iRestuarentInfoId)");     
                }
                $sQuery->bindValue(':iStampcardMaxStamps', $oJSONStampcard->iStampcardMaxStamps);
                $sQuery->bindValue(':iFK_iRestuarentInfoId', $iRestuarentInfoId);
                $sQuery->execute();
                
                $oStampcard['result'] = 'true';
            }
        }
        return $oStampcard;
        
    }
    
    /* Get the stampcard for the restuarent/menucard to show max number of stamps to redeme a cup of coffe*/
    public function GetStampcardApp($iMenucardSerialNumber) {
        
        $oStampcard = array(
                'iStampcardMaxStamps' => ''
            );
        
        //Get stampcard based on the menucard serialnumber
        $sQuery = $this->conPDO->prepare("SELECT iStampcardMaxStamps FROM stampcard
                                            INNER JOIN `menucard`
                                            ON menucard.`iMenucardSerialNumber` = :iMenucardSerialNumber
                                            WHERE stampcard.`iFK_iRestuarentInfoId` = menucard.`iFK_iRestuarentInfoId`");
        $sQuery->bindValue(":iMenucardSerialNumber", $iMenucardSerialNumber);
        $sQuery->execute();
        $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
        $iStampcardMaxStamps = $aResult['iStampcardMaxStamps'];
        
        $oStampcard['iStampcardMaxStamps'] = $iStampcardMaxStamps;
        
        //Return to MenucardController
        return $oStampcard;
    
    }
    
    //Function for when user scan QRcode
    public function UseStamp() {
        
        $oStampcard = array(
                'sFunction' => 'UseStamp',
                'result' => false
            );
        
         //Allow all, NOT SAFE
        header('Access-Control-Allow-Origin: *');  
        
        /* Only allow trusted, MUCH more safe
        header('Access-Control-Allow-Origin: spjæl.dk');
        header('Access-Control-Allow-Origin: xn--spjl-xoa.sk');
        header('Access-Control-Allow-Origin: www.spjæl.dk');
        header('Access-Control-Allow-Origin: www.xn--spjl-xoa.dk');
        */
        
        
        //Get $sCustomerId  and iMenucardSerialNumber from the App API call
        if(isset($_GET['QRcodeData']) && isset($_GET['sCustomerId']) && isset($_GET['iMenucardSerialNumber'])) {
            
            $sCustomerId = $_GET['sCustomerId'];
            $sQRcodeData = $_GET['QRcodeData'];
            $iMenucardSerialNumber = $_GET['iMenucardSerialNumber'];

            $sQuery = $this->conPDO->prepare("SELECT iRestuarentInfoId FROM restuarentinfo 
                                                WHERE sRestuarentInfoQrcodeData = :QRcodeData");
            $sQuery->bindValue(':QRcodeData', $sQRcodeData);
            $sQuery->execute();
            $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
            $iRestuarentInfoId = $aResult['iRestuarentInfoId'];
            
            //Get stampcardid
            $sQuery = $this->conPDO->prepare("SELECT iStampcardId FROM stampcard WHERE iFK_iRestuarentInfoId = :iRestuarentInfoId");
            $sQuery->bindValue(":iRestuarentInfoId", $iRestuarentInfoId);
            $sQuery->execute();
            $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
            $iStampcardId = $aResult['iStampcardId'];

            //Update stampcard card and increment number og given stamps by 1
            $sQuery = $this->conPDO->prepare("UPDATE stampcard SET iStampcardNumberOfGivenStamps = iStampcardNumberOfGivenStamps + 1 WHERE iFK_iRestuarentInfoId = :iRestuarentInfoId");
            $sQuery->bindValue(":iRestuarentInfoId", $iRestuarentInfoId);
            $sQuery->execute();

            //Insert stamp used into stamp table
            $sQuery = $this->conPDO->prepare("INSERT INTO stamp (dtStampDateTime,sCustomerId,iFK_iStampcardId,iFK_iMenucardSerialNumber) VALUES (NOW(),:sCustomerId,:iStampcardId,:iFK_iMenucardSerialNumber)");
            $sQuery->bindValue(':iStampcardId', $iStampcardId);
            $sQuery->bindValue(':sCustomerId', $sCustomerId);
            $sQuery->bindValue(":iFK_iMenucardSerialNumber", $iMenucardSerialNumber);
            $sQuery->execute();

            $oStampcard['result'] = 'true';
            
        }
       
        return $oStampcard;
    }
    
    //Function for when user redems the stamcard to get free cup of coffe
    public function RedemeStampcard() {
        
        $oStampcard = array(
                'sFunction' => 'RedemeStampcard',
                'result' => false
            );
        
         //Allow all, NOT SAFE
        header('Access-Control-Allow-Origin: *');  
        
        /* Only allow trusted, MUCH more safe
        header('Access-Control-Allow-Origin: spjæl.dk');
        header('Access-Control-Allow-Origin: xn--spjl-xoa.sk');
        header('Access-Control-Allow-Origin: www.spjæl.dk');
        header('Access-Control-Allow-Origin: www.xn--spjl-xoa.dk');
        */
        
        if(isset($_GET['iMenucardSerialNumber']) && isset($_GET['sCustomerId'])) {
        
            $iMenucardSerialNumber = $_GET['iMenucardSerialNumber'];
            $sCustomerId = $_GET['sCustomerId'];
            
            //Get iRestuarentInfoId
            $sQuery = $this->conPDO->prepare("SELECT iFK_iRestuarentInfoId FROM menucard WHERE iMenucardSerialNumber = :iMenucardSerialNumber");
            $sQuery->bindValue(":iMenucardSerialNumber", $iMenucardSerialNumber);
            $sQuery->execute();
            $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
            $iRestuarentInfoId = $aResult['iFK_iRestuarentInfoId'];
                    
            //Check for iStampcardMaxStamps to see how many stamps it takes to get one free cup of coffe
            $sQuery = $this->conPDO->prepare("SELECT iStampcardMaxStamps,iStampcardId FROM stampcard WHERE iFK_iRestuarentInfoId = :iRestuarentInfoId");
            $sQuery->bindValue(":iRestuarentInfoId", $iRestuarentInfoId);
            $sQuery->execute();
            $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
            //Convert string to int
            $iStampcardMaxStamps = intval($aResult['iStampcardMaxStamps']);
            $iStampcardId = $aResult['iStampcardId'];

            //Count number of stamps for the user
            //Check if there are enough stamps to get one free cup of coffe
            $sQuery = $this->conPDO->prepare("SELECT COUNT(*) as number FROM stamp WHERE sCustomerId = :sCustomerId AND iStampUsed = '0'");
            $sQuery->bindValue(":sCustomerId", $sCustomerId);
            $sQuery->execute();
            $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);

            //Convert string to int
            $iStamps = intval($aResult['number']);


            //Calculate if there is enough stamps for one free cup of coffe.
            //Antal stempler divideret med antal stempler det kræver at få en kop gratis kaffe
            if($iStamps/$iStampcardMaxStamps >= 1) {

                //Set $iStampcardMaxStamps number of stamps to used
                $sQuery = $this->conPDO->prepare("UPDATE stamp SET iStampUsed = '1'
                                                    WHERE sCustomerId = :sCustomerId 
                                                    AND iStampUsed = '0' AND iFK_iStampcardId = :iStampcardId");
                $sQuery->bindValue(":sCustomerId", $sCustomerId);
                $sQuery->bindValue(":iStampcardId", $iStampcardId);
                $sQuery->execute();
                
                $oStampcard['result'] = 'true';
            } else {
                $oStampcard['result'] = false;
            }
        }
        return $oStampcard;
    }
    
    
    /* Get stampcard for the restuarant/menucard*/
    public function GetStampcard() {

         $oStampcard = array(
                'sFunction' => 'GetStampcard',
                'result' => false
            );
            
        //Check if session is started
        if(!isset($_SESSION['sec_session_id']))
        { 
            $this->oSecurityController->sec_session_start();
        }
        
        //Check if user is logged in
        if($this->oSecurityController->login_check() == true)
        {
            $sQuery = $this->conPDO->prepare("SELECT iRestuarentInfoId FROM restuarentinfo 
                                                INNER JOIN users
                                                ON users.sUsername = :sUsername
                                                INNER JOIN company
                                                ON company.iCompanyId = users.iFK_iCompanyId");
            $sQuery->bindValue(':sUsername', $_SESSION['username']);
            $sQuery->execute();
            $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
            $iRestuarentInfoId = $aResult['iRestuarentInfoId'];
            
            //Get stampcard
            $sQuery = $this->conPDO->prepare("SELECT iStampcardMaxStamps,iStampcardNumberOfGivenStamps FROM stampcard 
                                                WHERE iFK_iRestuarentInfoId = :iRestuarentInfoId");
            $sQuery->bindValue(':iRestuarentInfoId', $iRestuarentInfoId);
            $sQuery->execute();
            $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
            
            //Create GoogleChart
            $charturl = $this->CreateGoogleChart();
            
            
            $oStampcard['stampcard'] = $aResult;
            $oStampcard['stampcard']['charturl'] = $charturl;
            $oStampcard['result'] = true;
            
            return $oStampcard;
        }
    }
      
    private function CreateGoogleChart () {
        
        //TODO: get all stamps given 
        
        
        $url = 'https://chart.googleapis.com/chart?cht=lc';
        
        //TODO: Data to change
        $stamps_pr_month = '&chd=t:27,25,20,31,25,39,25,31,26,28,17,28|2,4,8,2,5,9,2,5,7,2,8,1';
        
        //Data labels
        $datalabels = '&chdl=Antal stempler givet i alt 227|Antal gratis kopper kaffe givet ud 25';
        
        //Data show on line
        $datavalueonline = '&chm=N,000000,0,0,10,,e|N,000000,0,1,10,,e|N,000000,0,2,10,,e|N,000000,0,3,10,,e|N,000000,0,4,10,,e|N,000000,0,5,10,,e|N,000000,0,6,10,,e|N,000000,0,7,10,,e|N,000000,0,8,10,,e|N,000000,0,9,10,,e|N,000000,0,10,10,,e|N,000000,0,11,10,,e|N,000000,1,0,10,,e|N,000000,1,1,10,,e|N,000000,1,2,10,,e|N,000000,1,3,10,,e|N,000000,1,4,10,,e|N,000000,1,5,10,,e|N,000000,1,6,10,,e|N,000000,1,7,10,,e|N,000000,1,8,10,,e|N,000000,1,9,10,,e|N,000000,1,10,10,,e|N,000000,1,11,10,,e|N,000000,1,12,10,,e';
        
        //Set color of data legend and line colorto blue and green
        $chatlegendlinecolor = '&chco=0000FF,00FF00';
        
        $chartsize = '&chs=550x300';

        $x_axis = '0:|Jan|Feb|Mar|Apr|Maj|Jun|Jul|Aug|Sep|Okt|Nov|Dec|';
        $y_axis = '1:|0|25|50|75|100';
        
        $url = $url.$chartsize.$chatlegendlinecolor.$stamps_pr_month.'&chxt=x,y&chxl='.$x_axis.$y_axis.$datalabels.$datavalueonline;
        
        return $url;
        
    }

    public function __destruct() {
        ;
    }
}
?>
