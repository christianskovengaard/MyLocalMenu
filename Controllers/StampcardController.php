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
    
    public function SetMaxNumberOfStamps () {
        
    }
    
    public function SaveStampcard() {
        
    }

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
        
        $url = 'https://chart.googleapis.com/chart?cht=lc';
        
        //Data to change
        $stamps_pr_month = '&chd=t:27,25,60,31,25,39,25,31,26,28,80,28';
        
        //Data labels
        $datalabels = '&chdl=Jan 27|Feb 25|Mar 60|Apr 31|Maj 25|Jun 39|Jul 25|Aug 31|Sep 26|Okt 28|Nov 80|Dec 28';
        
        //Data show on line
        $datavalueonline = '&chm=N,000000,0,0,10,,e|N,000000,0,1,10,,e|N,000000,0,2,10,,e|N,000000,0,3,10,,e|N,000000,0,4,10,,e|N,000000,0,5,10,,e|N,000000,0,6,10,,e|N,000000,0,7,10,,e|N,000000,0,8,10,,e|N,000000,0,9,10,,e|N,000000,0,10,10,,e|N,000000,0,11,10,,e';
        
        //Set to blue
        $chatlinecolor = '&chco=0000FF';
        
        $chartsize = '&chs=550x300';

        $x_axis = '0:|Jan|Feb|Mar|Apr|Maj|Jun|Jul|Aug|Sep|Okt|Nov|Dec|';
        $y_axis = '1:|0|25|50|75|100';
        
        $url = $url.$chartsize.$chatlinecolor.$stamps_pr_month.'&chxt=x,y&chxl='.$x_axis.$y_axis.$datalabels.$datavalueonline;
        
        return $url;
        
    }

    public function __destruct() {
        ;
    }
}
?>
