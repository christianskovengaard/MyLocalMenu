<?php

if(isset($_GET['sFunction']))
{    
    $sFunction = $_GET['sFunction'];

    switch ($sFunction)
    {
        case "SaveMenucard":
            require_once '../Controllers/MenucardController.php';
            $oMenucardController = new MenuCardController();
            if($oMenucardController->AddMenucard() == true)
            {
                $sResult = '{"sFunction":"SaveMenucard","result":"True"}';
            }
            else
            {
                $sResult = '{"sFunction":"SaveMenucard","result":"False"}';
            }
            echo $sResult;

        break;
        
        default:
                $result = '{"sFunction":"'.$sFunction.'","result":"Error - Unknown function"}';
                echo $result;
        break;
        
        case "GetMenucardWithSerialNumber":
            require_once '../Controllers/MenucardController.php';
            $oMenucardController = new MenuCardController();
            $result = $oMenucardController->GetMenucardWithSerialNumber();
            if($result['result'] == false)
            {
                $sResult = '{"sFunction":"GetMenucardWithSerialNumber","result":"False"}';
            }
            if($result['result'] == true)
            {
                $sResult = json_encode($result);
            }
            echo $sResult;

        break;
        
        case "GetMenucard":
            require_once '../Controllers/MenucardController.php';
            $oMenucardController = new MenuCardController();
            $result = $oMenucardController->GetMenucard();
            if($result['result'] == false)
            {
                $sResult = '{"sFunction":"GetMenucard","result":"False"}';
            }
            if($result['result'] == true)
            {
                $sResult = json_encode($result);
            }
            echo $sResult;

        break;
        
        
        case "DeactivateMenucard":
            require_once '../Controllers/MenucardController.php';
            $oMenucardController = new MenuCardController();
            $result = $oMenucardController->DeactivateMenucard();
            if($result['result'] == false)
            {
                $sResult = '{"sFunction":"DeactivateMenucard","result":"False"}';
            }
            if($result['result'] == true)
            {
                $sResult = json_encode($result);
            }
            echo $sResult;

        break;
        
        
        case "ActivateMenucard":
            require_once '../Controllers/MenucardController.php';
            $oMenucardController = new MenuCardController();
            $result = $oMenucardController->ActivateMenucard();
            if($result['result'] == false)
            {
                $sResult = '{"sFunction":"ActivateMenucard","result":"False"}';
            }
            if($result['result'] == true)
            {
                $sResult = json_encode($result);
            }
            echo $sResult;

        break;
        
        
        default:
                $result = '{"sFunction":"'.$sFunction.'","result":"Error - Unknown function"}';
                echo $result;
        break;

    }
}
?>
