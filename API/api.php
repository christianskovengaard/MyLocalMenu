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
              
        /*'case "UpdateMenucard":
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

        break;*/
        
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
    
        case "GetMessagesAndStampsApp":
            require_once '../Controllers/MessageController.php';
            $oMessageController = new MessageController();
            $result = $oMessageController->GetMessagesAndStampsApp();
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
       
        case "SaveStampcard":
            require_once '../Controllers/StampcardController.php';
            $oStampcard = new StampcardController();
            $result = $oStampcard->SaveStampcard();
            $sResult = json_encode($result);
            echo $sResult;
        break;
    
        case "GetStamp":
            require_once '../Controllers/StampcardController.php';
            $oStampcard = new StampcardController();
            $result = $oStampcard->GetStamp();
            $sResult = json_encode($result);
            echo $sResult;
        break;
    
        case "RedemeStampcard":
            require_once '../Controllers/StampcardController.php';
            $oStampcard = new StampcardController();
            $result = $oStampcard->RedemeStampcard();
            $sResult = json_encode($result);
            echo $sResult;
        break;
    
        case "GetZipcodesAndCities":
            require_once '../Controllers/ZipcodeCityController.php';
            $oZipcodeCity = new ZipcodeCityController();
            $result = $oZipcodeCity->GetZipcodesAndCities();
            $sResult = json_encode($result);
            echo $sResult;
        break;
    
        case "GetZipcode":
            require_once '../Controllers/ZipcodeCityController.php';
            $oZipcodeCity = new ZipcodeCityController();
            $result = $oZipcodeCity->GetZipcode();
            $sResult = json_encode($result);
            echo $sResult;
        break;

        case "GetCityname":
            require_once '../Controllers/ZipcodeCityController.php';
            $oZipcodeCity = new ZipcodeCityController();
            $result = $oZipcodeCity->GetCityname();
            $sResult = json_encode($result);
            echo $sResult;
        break;
    
        
        case "ResetPasswordNoToken":
            require_once '../Controllers/UserController.php';
            $oUser = new UserController();
            $result = $oUser->ResetPasswordNoToken();
            $sResult = json_encode($result);
            echo $sResult;
        break;
        
        case "SendResetPasswordRequest":
            require_once '../Controllers/UserController.php';
            $oUser = new UserController();
            $result = $oUser->SendResetPasswordRequest();
            $sResult = json_encode($result);
            echo $sResult;
        break;
        
        case "UpdateRedemeCode":
            require_once '../Controllers/StampcardController.php';
            $oStampcard = new StampcardController();
            $result = $oStampcard->UpdateRedemeCode();
            $sResult = json_encode($result);
            echo $sResult;
        break;
        
        case "UpdateStampcardText":
            require_once '../Controllers/StampcardController.php';
            $oStampcard = new StampcardController();
            $result = $oStampcard->UpdateStampcardText();
            $sResult = json_encode($result);
            echo $sResult;
        break;
        
        case "AutocompleteCafename":
            require_once '../Controllers/RestuarentController.php';
            $oRestuarentController = new RestuarentController();
            $result = $oRestuarentController->SearchForRestuarentname();
            $sResult = json_encode($result);
            echo $sResult;
        break;

        case "GetUsersImageLibrary":
            require_once "../Controllers/ImageController.php";
            $oImageController = new ImageController();
            echo json_encode($oImageController->GetImages());
        break;

        case 'DeleteImage':
            require_once "../Controllers/ImageController.php";
            $oImageController = new ImageController();
            echo json_encode($oImageController->DeleteImage());
        break;

        case 'PreviewImage':
            require_once "../Controllers/ImageController.php";
            $oImageController = new ImageController();
            $oImageController->PreviewImage();
        break;

        case 'SaveEidtImage':
            require_once "../Controllers/ImageController.php";
            $oImageController = new ImageController();
            echo json_encode($oImageController->SaveEidtImage());
        break;
        
        default:
                $result = '{"sFunction":"'.$sFunction.'","result":"Error - Unknown function"}';
                echo $result;
        break;

    }
}


if(isset($_POST['sFunction'])) {
    $sFunction = $_POST['sFunction'];

    switch ($sFunction) {
        
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

        case "UploadImage":
            require_once "../Controllers/ImageController.php";
            $oImageController = new ImageController();
            echo json_encode($oImageController->UploadImage());

        break;

        default:
                $result = '{"sFunction":"'.$sFunction.'","result":"Error - Unknown function"}';
                echo $result;
        break;
    }
}

?>
