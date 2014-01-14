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
              
        case "UpdateMenucard":
            require_once '../Controllers/MenucardController.php';
            $oMenucardController = new MenuCardController();
            $result = $oMenucardController->UpdateMenucard();
            if($result['result'] == true)
            {
                $sResult = '{"sFunction":"UpdateMenucard","result":"True"}';
            }
            else
            {
                $sResult = '{"sFunction":"UpdateMenucard","result":"False"}';
            }
            echo $sResult;

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
        
        
        case "GetMenucardAdmin":
            require_once '../Controllers/MenucardController.php';
            $oMenucardController = new MenuCardController();
            $result = $oMenucardController->GetMenucardAdmin();
            if($result['result'] == false)
            {
                $sResult = '{"sFunction":"GetMenucardAdmin","result":"False"}';
            }
            if($result['result'] == true)
            {
                $sResult = json_encode($result);
            }
            echo $sResult;

        break;
        
        
        case "GetMenucardWithRestuarentName":
            require_once '../Controllers/MenucardController.php';
            $oMenucardController = new MenuCardController();
            $result = $oMenucardController->GetMenucardWithRestuarentName();
            if($result['result'] == false)
            {
                $sResult = '{"sFunction":"GetMenucardWithRestuarentName","result":"False"}';
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
        
        case "GetRestuarentNames":
            require_once '../Controllers/RestuarentController.php';
            $oRestuarentController = new RestuarentController();
            $result = $oRestuarentController->GetRestuarentNames();
            if($result['result'] == false)
            {
                $sResult = '{"sFunction":"GetRestuarentNames","result":"False"}';
            }
            if($result['result'] == true)
            {
                $sResult = json_encode($result);
            }
            echo $sResult;

        break;
        
        
        case "AddNewUser":
            require_once '../Controllers/UserController.php';
            $oUserController = new UserController();
            $result = $oUserController->AddNewUser();
            if($result['result'] == false)
            {
                $sResult = '{"sFunction":"AddNewUser","result":"False"}';
            }
            if($result['result'] == true)
            {
                $sResult = json_encode($result);
            }
            echo $sResult;

        break;
        
        case "RegisterNewUser":
            require_once '../Controllers/UserController.php';
            $oUserController = new UserController();
            $result = $oUserController->RegisterNewUser();
            if($result['result'] == false)
            {
                $sResult = '{"sFunction":"RegisterNewUser","result":"False"}';
            }
            if($result['result'] == true)
            {
                $sResult = json_encode($result);
            }
            echo $sResult;

        break;
        
        case "GetOpeningHours":
            require_once '../Controllers/TimeController.php';
            $oTimeController = new TimeController();
            $result = $oTimeController->GetOpeningHours();
            if($result['result'] == false)
            {
                $sResult = '{"sFunction":"GetOpeningHours","result":"False"}';
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
