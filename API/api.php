<?php

if(isset($_GET['sFunction']))
{    
    $sFunction = $_GET['sFunction'];

    switch ($sFunction)
    {
        case "SaveMenucard":
            require_once '../Controllers/MenucardController.php';
            $oMenucardController = new MenuCardController();
            $result = $oMenucardController->AddMenucard();
            if($result['result'] == true)
            {
                $sResult = json_encode($result);
            }
            else
            {
                $sResult = json_encode($result);
            }
            echo $sResult;

        break;
              
        case "UpdateMenucard":
            require_once '../Controllers/MenucardController.php';
            $oMenucardController = new MenuCardController();
            $result = $oMenucardController->UpdateMenucard();
            if($result['result'] == true)
            {
                $sResult = json_encode($result);
            }
            else
            {
                $sResult = json_encode($result);
            }
            echo $sResult;

        break;
        
        case "GetMenucardWithSerialNumber":
            require_once '../Controllers/MenucardController.php';
            $oMenucardController = new MenuCardController();
            $result = $oMenucardController->GetMenucardWithSerialNumber();
            if($result['result'] == false)
            {
                $sResult = json_encode($result);
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
            //var_dump($result);
            if($result['result'] == false)
            {
                $sResult = json_encode($result);
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
                $sResult = json_encode($result);
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
                $sResult = json_encode($result);
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
                $sResult = json_encode($result);
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
                $sResult = json_encode($result);
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
                $sResult = json_encode($result);
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
                $sResult = json_encode($result);
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
                $sResult = json_encode($result);
            }
            if($result['result'] == true)
            {
                $sResult = json_encode($result);
            }
            echo $sResult;

        break;
               
        case "ResetPassword":
            require_once '../Controllers/UserController.php';
            $oUserController = new UserController();
            $result = $oUserController->ResetPassword();
            if($result['result'] == false)
            {
                $sResult = json_encode($result);
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
                $sResult = json_encode($result);
            }
            if($result['result'] == true)
            {
                $sResult = json_encode($result);
            }
            echo $sResult;

        break;
        
        case "GetUserinformation":
            require_once '../Controllers/UserController.php';
            $oUserController = new UserController();
            $result = $oUserController->GetUserinformation();
            
            if($result['result'] == false)
            {
                $sResult = json_encode($result);
            }
            if($result['result'] == true)
            {
                $sResult = json_encode($result);
            }
            echo $sResult;

        break;
        
        
        case "UpdateUserinformation":
            require_once '../Controllers/UserController.php';
            $oUserController = new UserController();
            $result = $oUserController->UpdateUserinformation();
            if($result['result'] == false)
            {
                $sResult = json_encode($result);
            }
            if($result['result'] == true)
            {
                $sResult = json_encode($result);
            }
            echo $sResult;

        break;
        
        case "UpdateRestuarentInfo":
            require_once '../Controllers/RestuarentController.php';
            $oRestuarentController = new RestuarentController();
            $result = $oRestuarentController->UpdateRestuarentInfo();
            if($result['result'] == false)
            {
                $sResult = json_encode($result);
            }
            if($result['result'] == true)
            {
                $sResult = json_encode($result);
            }
            echo $sResult;

        break;
        
        case "GenerateQRcode":
            require_once '../Controllers/QRcodeController.php';
            $oQRcodeController = new QRcodeController();
            $result = $oQRcodeController->GenerateQRcode();
            $sResult = json_encode($result);
            echo $sResult;

        break;
    
        case "GetMessages":
            require_once '../Controllers/MessageController.php';
            $oMessageController = new MessageController();
            $result = $oMessageController->GetMessages();
            $sResult = json_encode($result);
            echo $sResult;

        break;
    
        case "SaveMessage":
            require_once '../Controllers/MessageController.php';
            $oMessageController = new MessageController();
            $result = $oMessageController->SaveMessage();
            $sResult = json_encode($result);
            echo $sResult;
        break;
    
        case "GetStampcard":
            require_once '../Controllers/StampcardController.php';
            $oStampcard = new StampcardController();
            $result = $oStampcard->GetStampcard();
            $sResult = json_encode($result);
            echo $sResult;
        break;
       
        default:
                $result = '{"sFunction":"'.$sFunction.'","result":"Error - Unknown function"}';
                echo $result;
        break;

    }
}
?>
