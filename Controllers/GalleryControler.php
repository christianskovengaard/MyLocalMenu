<?php

/**
 * Created by PhpStorm.
 * User: Benjaco
 * Date: 02-07-2014
 * Time: 22:48
 */
class GalleryController
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
            $sQuery = $this->conPDO->prepare("SELECT iGalleryId, sGalleryImage, iGalleryImagePlaceInList FROM gallery WHERE iFK_iResturentInfoId = :iFK_iRestuarentInfoId ORDER BY iGalleryImagePlaceInList");
            $sQuery->bindValue(":iFK_iRestuarentInfoId", $this->GetResturantId());
            $sQuery->execute();
            while ($aResult = $sQuery->fetch(PDO::FETCH_ASSOC)) {
                $oMessage['images'][] = array(
                    'id' => $aResult['iGalleryId'],
                    'n' => $aResult['sGalleryImage'],
                    'olace' => $aResult['iGalleryImagePlaceInList']
                );
            }
            $oMessage['result'] = true;

        }

        return $oMessage;
    }

    public function AddImage()
    {
        $oMessage = array(
            'sFunction' => 'AddImage',
            'result' => false,
            'image' => ''
        );
        if (isset($_GET['iImageId'])) {
            //Check if session is started
            if (!isset($_SESSION['sec_session_id'])) {
                $this->oSecurityController->sec_session_start();
            }
            if ($this->oSecurityController->login_check() == true) {
                $imageid = $_GET['iImageId'];
                $image = false;
                $sQuery = $this->conPDO->prepare("SELECT * FROM images WHERE iImageId = :imageId AND iFK_iRestuarentInfoId = :resturentid");
                $sQuery->bindValue(':imageId', $imageid);
                $sQuery->bindValue(':resturentid', $this->GetResturantId());
                $sQuery->execute();
                $rows = $sQuery->rowCount();
                if ($rows == 1) {
                    $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
                    if (file_exists("../imgmsg/" . $aResult['sImageName'])) {
                        $image = $aResult['sImageName'];
                    }
                }
                if ($image) {
                    $resId = $this->GetResturantId();
                    $this->LoadPhpImageMagician();
                    $oImageL = new imageLib("../imgmsg/" . $image);

                    $oMessageFinishImageAspect = (object)Array(
                        "max" => 1.42857142857,
                        "min" => 0.42857142857
                    );

                    $iNeturalAspect = $oImageL->getHeight() / $oImageL->getWidth();

                    if ($iNeturalAspect < $oMessageFinishImageAspect->min) {
                        $oImageL->resizeImage(700, 300, 4);
                    } else if ($iNeturalAspect > $oMessageFinishImageAspect->max) {
                        $oImageL->resizeImage(700, 1000, 4);
                    } else {
                        $oImageL->resizeImage(700, 700 * $iNeturalAspect, 4);
                    }
                    $oImageL->saveImage("../img_gallery/" . $image);

                    $sQuery = $this->conPDO->prepare("SELECT max(iGalleryImagePlaceInList) as max FROM gallery WHERE iFK_iResturentInfoId = :resturentid");
                    $sQuery->bindValue(':resturentid', $resId);
                    $sQuery->execute();
                    $nextInList = null;
                    if ($sQuery->rowCount() == 0) {
                        $nextInList = 1;
                    }else {
                        $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);
                        $nextInList = intval($aResult['max']);
                        $nextInList++;
                    }

                    $sQuery = $this->conPDO->prepare("INSERT INTO gallery (iFK_iResturentInfoId, sGalleryImage, iGalleryImagePlaceInList) VALUES (:resturentId, :image, :placeinlist)");
                    $sQuery->bindValue(":resturentId", $resId);
                    $sQuery->bindValue(":image", $image);
                    $sQuery->bindValue(":placeinlist", $nextInList);
                    $sQuery->execute();

                    $oMessage['image'] = $image;
                    $oMessage['id'] = $this->conPDO->lastInsertId();
                    $oMessage['result'] = true;
                }


            }
        }
        return $oMessage;

    }
        public function RemoveImage()
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

                    $sQuery = $this->conPDO->prepare("SELECT * FROM gallery WHERE iGalleryId = :imageId AND iFK_iResturentInfoId = :resturentid");
                    $sQuery->bindValue(':imageId', $imageId);
                    $sQuery->bindValue(':resturentid', $userid);
                    $sQuery->execute();
                    $rows = $sQuery->rowCount();
                    if ($rows == 1) {
                        $aResult = $sQuery->fetch(PDO::FETCH_ASSOC);

                        if (file_exists("../img_gallery/" . $aResult['sGalleryImage'])) {

                            unlink("../img_gallery/" . $aResult['sGalleryImage']);
                        }

                        $sQuery = $this->conPDO->prepare("DELETE FROM gallery WHERE iGalleryId = :imageId AND iFK_iResturentInfoId = :resturentid");
                        $sQuery->bindValue(':imageId', $imageId);
                        $sQuery->bindValue(':resturentid', $userid);
                        $sQuery->execute();


                        $sQuery = $this->conPDO->prepare("SELECT * FROM gallery WHERE iFK_iResturentInfoId = :resturentid");
                        $sQuery->bindValue(':resturentid', $userid);
                        $sQuery->execute();
                        $inlist = 1;
                        while ($aResult = $sQuery->fetch(PDO::FETCH_ASSOC)) {
                            $sQueryIn = $this->conPDO->prepare("UPDATE gallery SET iGalleryImagePlaceInList = :inlist WHERE iGalleryId = :imageId AND iFK_iResturentInfoId = :resturentid");
                            $sQueryIn->bindValue(':resturentid', $userid);
                            $sQueryIn->bindValue(':inlist', $inlist);
                            $sQueryIn->bindValue(':imageId', $aResult['iGalleryId']);

                            $sQueryIn->execute();
                            $inlist++;
                        }



                        $oMessage['result'] = true;


                    }


                }
            }
            return $oMessage;
        }


        public function ReorderImage()
        {
            $oMessage = array(
                'sFunction' => 'ReorderImage',
                'result' => false
            );
            if (isset($_GET['order'])) {
                $order = explode('-',$_GET['order']);
                //Check if session is started
                if (!isset($_SESSION['sec_session_id'])) {
                    $this->oSecurityController->sec_session_start();
                }

                //Check if user is logged in
                if ($this->oSecurityController->login_check() == true) {
                    $userid = $this->GetResturantId();

                    foreach($order as $key=>$value) {
                        $key++;
                        $sQuery = $this->conPDO->prepare("UPDATE gallery SET iGalleryImagePlaceInList = :inlist WHERE iGalleryId = :imageId AND iFK_iResturentInfoId = :resturentid");
                        $sQuery->bindValue(':resturentid', $userid);
                        $sQuery->bindValue(':inlist', $key);
                        $sQuery->bindValue(':imageId', $value);
                        $sQuery->execute();
                    }


                }
            }
            return $oMessage;
        }


}