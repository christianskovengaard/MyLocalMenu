<?php

/**
 * Created by PhpStorm.
 * User: Benjaco
 * Date: 16-06-2014
 * Time: 13:39
 */
class ImageController
{

    private $conPDO;

    private $oSecurityController;


    function __construct()
    {
        require_once 'DatabaseController.php';
        $oDatabaseController = new DatabaseController();
        $this->conPDO = $oDatabaseController->ConnectToDatabase();

        require_once 'SecurityController.php';
        $this->oSecurityController = new SecurityController();

    }

    private function LoadPhpImageMagician()
    {
        require "../Classes/PhpImageMagicianClass.php";
    }

    private function GetResturantId()
    {
        $sQuery = $this->conPDO->prepare("SELECT iRestuarentInfoId FROM restuarentinfo
                                                        INNER JOIN company
                                                        ON company.iCompanyId = restuarentinfo.iFK_iCompanyInfoId
                                                        INNER JOIN users
                                                        ON users.iFK_iCompanyId = company.iCompanyId
                                                        WHERE users.sUsername = :sUsername");
        $sQuery->bindValue(':sUsername', $_SESSION['username']);
        $sQuery->execute();
        $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
        return $aResult['iRestuarentInfoId'];

    }

    public function GetImages()
    {
        $oMessage = array(
            'sFunction' => 'GetImages',
            'result' => false,
            'images' => array()
        );
        //Check if session is started
        if (!isset($_SESSION['sec_session_id'])) {
            $this->oSecurityController->sec_session_start();
        }

        //Check if user is logged in
        if ($this->oSecurityController->login_check() == true) {
            $sQuery = $this->conPDO->prepare("SELECT iImageId, sImageName, sImageDate FROM images WHERE iFK_iRestuarentInfoId = :iFK_iRestuarentInfoId ORDER BY iImageId DESC ");
            $sQuery->bindValue(":iFK_iRestuarentInfoId", $this->GetResturantId());
            $sQuery->execute();
            while ($aResult = $sQuery->fetch(PDO::FETCH_ASSOC)) {
                $oMessage['images'][] = array(
                    'id' => $aResult['iImageId'],
                    'n' => $aResult['sImageName'],
                    'd' => $aResult['sImageDate']
                );
            }
            $oMessage['result'] = true;

        }

        return $oMessage;
    }

    public function DeleteImage()
    {
        $oMessage = array(
            'sFunction' => 'DeleteImage',
            'result' => false
        );
        if (isset($_GET['imageid'])) {
            $imageId = $_GET['imageid'];
            //Check if session is started
            if (!isset($_SESSION['sec_session_id'])) {
                $this->oSecurityController->sec_session_start();
            }

            //Check if user is logged in
            if ($this->oSecurityController->login_check() == true) {
                $userid = $this->GetResturantId();

                $sQuery = $this->conPDO->prepare("SELECT * FROM images WHERE iImageId = :imageId AND iFK_iRestuarentInfoId = :resturentid");
                $sQuery->bindValue(':imageId', $imageId);
                $sQuery->bindValue(':resturentid', $userid);
                $sQuery->execute();
                $rows = $sQuery->rowCount();
                if ($rows == 1) {
                    $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);

                    if (file_exists("../user_img/" . $aResult['sImageName'])) {

                        unlink("../user_img/" . $aResult['sImageName']);
                    }

                    $sQuery = $this->conPDO->prepare("DELETE FROM images WHERE iImageId = :imageId AND iFK_iRestuarentInfoId = :resturentid");
                    $sQuery->bindValue(':imageId', $imageId);
                    $sQuery->bindValue(':resturentid', $userid);
                    $sQuery->execute();

                    $oMessage['result'] = true;


                }


            }
        }
        return $oMessage;
    }

    public function UploadImage()
    {

        $oMessage = array(
            'sFunction' => 'UploadImage',
            'result' => false,
            'toSmall' => true
        );

        //Check if session is started
        if (!isset($_SESSION['sec_session_id'])) {
            $this->oSecurityController->sec_session_start();
        }

        //Check if user is logged in
        if ($this->oSecurityController->login_check() == true) {

            if (isset($_FILES['file'])) {
                $names = $_FILES['file']['name'];
                $types = $_FILES['file']['type'];
                $tmpnames = $_FILES['file']['tmp_name'];
                $errors = $_FILES['file']['error'];
                $sizes = $_FILES['file']['size'];

                $fil = array(
                    'name' => $names[0],
                    'type' => $types[0],
                    'tmp_name' => $tmpnames[0],
                    'error' => $errors[0],
                    'size' => $sizes[0]
                );


                if (getimagesize($fil['tmp_name'])) {

                    list($width, $height, $type, $attr) = getimagesize($fil['tmp_name']);

                    if($width>699 && $height>299){
                        $oMessage['toSmall']=false;
                        
                        $id = intval(file_get_contents("../app_data/image_upload_id.txt"));
                        $filename = $this->GetResturantId() . date('-Y-m-d-') . time() . '.' . end(explode(".", $fil['name']));
                        $location = '../user_img/' . $filename;

                        if ($fil['error'] == 0 && move_uploaded_file($fil['tmp_name'], $location)) {


                            $sQuery = $this->conPDO->prepare("INSERT INTO images (iFK_iRestuarentInfoId, sImageName, sImageDate) VALUES (:iFK_iRestuarentInfoId, :imageName, CURDATE())");

                            $sQuery->bindValue(":iFK_iRestuarentInfoId", $this->GetResturantId());
                            $sQuery->bindValue(":imageName", $filename);
                            $sQuery->execute();

                            $oMessage['result'] = true;

                            $oMessage['images'] = array(
                                'id' => $this->conPDO->lastInsertId(),
                                'n' => $filename,
                                'd' => date('Y-m-d')
                            );
                        }

                        $id++;
                        file_put_contents("../app_data/image_upload_id.txt", $id);

                    }


                   

                }


            }
        }


        return $oMessage;


    }


    public function PreviewImage()
    {
        if (isset($_GET['imageId'], $_GET['functions'])) {
            if (!isset($_SESSION['sec_session_id'])) {
                $this->oSecurityController->sec_session_start();
            }
            //Check if user is logged in
            if ($this->oSecurityController->login_check() == true) {
                $userid = $this->GetResturantId();
                $imageId = $_GET['imageId'];
                $sQuery = $this->conPDO->prepare("SELECT * FROM images WHERE iImageId = :imageId AND iFK_iRestuarentInfoId = :resturentid");
                $sQuery->bindValue(':imageId', $imageId);
                $sQuery->bindValue(':resturentid', $userid);
                $sQuery->execute();
                $rows = $sQuery->rowCount();
                if ($rows == 1) {
                    $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
                    $url = "../user_img/" . $aResult['sImageName'];

                    $this->LoadPhpImageMagician();

                    /** @var imageLib $newImage */
                    $newImage = $this->getProcessedImage($url, $_GET['functions']);
                    $newImage->showImage();
                }
            }
        }
    }

    private function getProcessedImage($url, $functions)
    {
        $image = new imageLib($url);
        foreach ($functions as $task) {
            switch($task){
                case 'sortHvid':
                    $image->greyScale();
                break;
                case 'rotateHojre':
                    $image->rotate();
                break;
                case 'rotateVenstre':
                    $image->rotate(270);
                break;
                case 'rotateHalv':
                    $image->rotate(180);
                break;
            }
            if (substr($task, 0, 4) === "crop") {
                $aCropInfo = explode("-", $task);
                $aCropInfo = array(
                    "x"=>floatval($aCropInfo[1])/100,
                    "y"=>floatval($aCropInfo[2])/100,
                    "width"=>floatval($aCropInfo[3])/100,
                    "height"=>floatval($aCropInfo[4])/100
                );
                $image->cropping($aCropInfo);
            }
        }
        return $image;
    }

    public function SaveEidtImage()
    {

        $oMessage = array(
            'sFunction' => 'SaveEidtImage',
            'result' => false
        );


        if (isset($_GET['imageId'], $_GET['functions'])) {

            if (!isset($_SESSION['sec_session_id'])) {
                $this->oSecurityController->sec_session_start();
            }

            //Check if user is logged in
            if ($this->oSecurityController->login_check() == true) {
                $userid = $this->GetResturantId();
                $imageId = $_GET['imageId'];

                $sQuery = $this->conPDO->prepare("SELECT * FROM images WHERE iImageId = :imageId AND iFK_iRestuarentInfoId = :resturentid");
                $sQuery->bindValue(':imageId', $imageId);
                $sQuery->bindValue(':resturentid', $userid);
                $sQuery->execute();
                $rows = $sQuery->rowCount();
                if ($rows == 1) {
                    $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
                    $url = "../user_img/" . $aResult['sImageName'];
                    $this->LoadPhpImageMagician();
                    /** @var imageLib $newImage */
                    $newImage = $this->getProcessedImage($url, $_GET['functions']);
                    $id = intval(file_get_contents("../app_data/image_upload_id.txt"));
                    $filename = $this->GetResturantId() . date('-Y-m-d-') . time() . $newImage->getFileExtension();
                    $location = '../user_img/' . $filename;
                    $newImage->saveImage($location);
                    $sQuery = $this->conPDO->prepare("INSERT INTO images (iFK_iRestuarentInfoId, sImageName, sImageDate) VALUES (:iFK_iRestuarentInfoId, :imageName, CURDATE())");
                    $sQuery->bindValue(":iFK_iRestuarentInfoId", $this->GetResturantId());
                    $sQuery->bindValue(":imageName", $filename);
                    $sQuery->execute();
                    $id++;
                    file_put_contents("../app_data/image_upload_id.txt", $id);

                    $oMessage['images'] = array(
                        'id' => $this->conPDO->lastInsertId(),
                        'n' => $filename,
                        'd' => date('Y-m-d')
                    );

                }
            }
        }

        return $oMessage;
    }
}