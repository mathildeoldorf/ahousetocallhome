<?php

if ($_SESSION) {
// REQUIRE FUNCTIONS.PHP TO RUN ERROR-FUNCTION AND GET CONTENTS OF DATA.JSON AND DECODE INTO A JSON-OBJECT
require_once(__DIR__.'/../functions.php'); 

// GET INFORMATION FROM SESSION TO POINT TO THE CORRECT USER IN THE CORRECT NESTED OBJECT (USERS / AGENTS)
$sUserType = $_SESSION['sUserType'];
$sUserId = $_SESSION['sUserId'];

if($sUserType != 'agents'){
    header('Location: profile.php');
}

// POINT TO THE USER IN SESSION
$jLoggedUser = $jData->$sUserType->$sUserId;

    if($_POST){

/********************************* TIME ***************************************/

$iCreatedTime = time();
$iCreatedTime = date('d-m-y', $iCreatedTime);

    $sStreet = $_POST['txtStreet'];
    $iStreetNumber = $_POST['iStreetNumber'];
    $iPostalCode = $_POST['iPostalCode'];
    $sCity = $_POST['sCity'];
    $sDescription = $_POST['txtDescription'];
    $iSize = $_POST['iSize'];
    $iPrice = $_POST['iPrice'];
    $iBedrooms = $_POST['iBedrooms'];
    $iRooms = $_POST['iRooms'];
    $aAImages = $_FILES['images'];
    $aImages = [];

    intval($iSize);
    intval($iPrice);


    $sPostalCodes = $jData->postalcodes;
    

    
/*************************************************************************************/
// DEFENSIVE CODING

/****************************************/
// IMAGE

// EMPTY 

    if(empty($aAImages)){
    sendErrorMessage('variable image [imgProperty] is missing',__LINE__);
    }

    $aImgCount = count($aAImages['name']);

        for($i = 0; $i < $aImgCount; $i++){

        $sImageName = $aAImages['name'][$i];
        $sUniqueImageName = uniqid(); // generating a unique id
        $sExtension = pathinfo($aAImages['name'][$i], PATHINFO_EXTENSION); // getting extension
        $sExtension = strtolower($sExtension); // convert to lowercase
        $sImageFileName = "$sUniqueImageName.$sExtension"; // giving a unique filename // or it could be $_FILES[imgProperty]['name'].$sExtension (will be the original name of the file)
        $sFileSize = $aAImages['size'][$i];
        $sTempFilePath = $aAImages['tmp_name'][$i];
        $sFilePath = __DIR__."/../images/properties/$sImageFileName";

        array_push($aImages, $sImageFileName);

        // NOT JPG JPEG PNG 

        $allowedFileExtension = ['png' ,'jpg', 'jpeg'];
        if(!in_array($sExtension,$allowedFileExtension) ) {
        sendErrorMessage('variable image [image] is not a valid filetype. The file must be JPG JPEG or PNG',__LINE__);
    }

        // IMAGE SIZE
        if($sFileSize < 20480){ //calculated in bytes (KB = 1024 B)
        sendErrorMessage('the file size of variable image [image] is too small. Min. size is 20KB',__LINE__);
        exit;
        }

        if($sFileSize > 5242880){
            sendErrorMessage('the file size of variable image [image] is too large. Max size is 5MB',__LINE__);
            exit;
        }

        move_uploaded_file($sTempFilePath, $sFilePath); // moving to destination - 2 arguments: 1) The temporary file [][] <-- a multidimensional associative array , 2) Path of the destination
    
        }

        $jProperty = new stdClass();
        $sPropertyUniqueId = uniqid();
        $jProperty->id = $sPropertyUniqueId;
        $jProperty->description = $sDescription;
        $jProperty->size = $iSize;
        $jProperty->price = $iPrice;
        $jProperty->beds = $iBedrooms;
        $jProperty->rooms = $iRooms;
        $jProperty->address = new stdClass();
        $jProperty->address->street = $sStreet;
        $jProperty->address->postalcode = $iPostalCode;
        
        // ACCESSING POSTALCODE COORDINATES IN THE POSTAL CODE OBJECT BY TAKING THE USER INPUT POSTALCODE AND USING THAT TO POINTING TO THE KEY OF THE ARRAY
        $jProperty->address->coordinates = $sPostalCodes->$iPostalCode; 
        $jProperty->address->streetnumber = $iStreetNumber;
        $jProperty->address->city = $sCity;

        $jProperty->images = $aImages;
        $jProperty->verification = 1;
        $jProperty->createdTime = $iCreatedTime;
        
        $jData->$sUserType->$sUserId->properties->$sPropertyUniqueId = $jProperty;

        filePutContents($jData, $sJSONFilePath);

        echo '{"status": 1, "message": "property created", "line":'. __LINE__.'}';
    
    }
}