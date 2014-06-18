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

    private function GetResturantId(){
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

    public function GetImages(){
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

    public function DeleteImage(){
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
                    if (file_exists("../imgmsg/" . $aResult['sImageName'])) {
                        unlink("../imgmsg/" . $aResult['sImageName']);

                        $sQuery = $this->conPDO->prepare("DELETE FROM images WHERE iImageId = :imageId AND iFK_iRestuarentInfoId = :resturentid");
                        $sQuery->bindValue(':imageId', $imageId);
                        $sQuery->bindValue(':resturentid', $userid);
                        $sQuery->execute();

                        $oMessage['result']=true;
                    }

                }




            }
        }
        return $oMessage;
    }

    public function UploadImage()
    {

        $oMessage = array(
            'sFunction' => 'UploadImage',
            'result' => false
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
                    $id = intval(file_get_contents("../app_data/image_upload_id.txt"));
                    $filename = $this->GetResturantId() . date( '-Y-m-d-') . time() . '.' . end(explode(".", $fil['name']));
                    $location = '../imgmsg/' . $filename;

                    if ($fil['error'] == 0 && move_uploaded_file($fil['tmp_name'], $location)) {




                        $sQuery = $this->conPDO->prepare("INSERT INTO images (iFK_iRestuarentInfoId, sImageName, sImageDate) VALUES (:iFK_iRestuarentInfoId, :imageName, CURDATE())");

                        $sQuery->bindValue(":iFK_iRestuarentInfoId", $this->GetResturantId());
                        $sQuery->bindValue(":imageName", $filename);
                        $sQuery->execute();

                        $oMessage['result'] = true;
                        $oMessage['location'] = $filename;
                        $oMessage['id'] = $this->conPDO->lastInsertId();

                        $oMessage['images'] = array(
                            'id' => $this->conPDO->lastInsertId(),
                            'n' => $filename,
                            'd' => date( 'Y-m-d')
                        );
                    }

                    $id++;
                    file_put_contents("../app_data/image_upload_id.txt", $id);


                }


            }
        }


        return $oMessage;


    }

}