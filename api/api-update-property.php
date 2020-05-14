<?php

if(!$_SESSION){
    header('Location: login.php');
    exit;
}

if($_SESSION){

// GET INFORMATION FROM SESSION TO POINT TO THE CORRECT USER IN THE CORRECT NESTED OBJECT (USERS / AGENTS)
$sUserType = $_SESSION['sUserType'];
$sUserId = $_SESSION['sUserId'];
$sPropertyId = $_SESSION['sPropertyId'];

if($sUserType != 'agents'){
    header('Location: profile.php');
    exit;
}
    if($_POST){

// REQUIRE FUNCTIONS.PHP TO RUN ERROR-FUNCTION AND GET CONTENTS OF DATA.JSON AND DECODE INTO A JSON-OBJECT
require_once(__DIR__.'/../functions.php'); 


// POINT TO THE USER IN SESSION
$jLoggedUser = $jData->$sUserType->$sUserId;

$jProperty = $jLoggedUser->properties->$sPropertyId;

// GET INFO FROM POST

    $sStreet = $_POST['txtStreet'];
    $iStreetNumber = $_POST['iStreetNumber'];
    $iPostalCode = $_POST['iPostalCode'];
    $sCity = $_POST['txtCity'];
    $sDescription = $_POST['txtDescription'];
    $iSize = $_POST['iSize'];
    $iPrice = $_POST['iPrice'];
    $iBedrooms = $_POST['iBedrooms'];
    $iRooms = $_POST['iRooms'];
    $aAImages = $_FILES['images'];
    $aImages = [];

    $iCreatedTime = time();
    $iCreatedTime = date('d-m-y', $iCreatedTime);

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

        // MOVE IMAGE INTO IMAGE FOLDER - // 2 arguments: 1) The temporary file [][] <-- a multidimensional associative array , 2) Path of the destination
        move_uploaded_file($sTempFilePath, $sFilePath);

        //UPDATE DATA IN THE RIGHT PATH IN THE DATABASE
        $jProperty->description = $sDescription;
        $jProperty->address->street = $sStreet;
        $jProperty->address->streetnumber = $iStreetNumber;
        $jProperty->address->postalcode = $iPostalCode;
        $jProperty->address->city = $sCity;
        
        $jProperty->size = $iSize;
        $jProperty->price = $iPrice;
        $jProperty->beds = $iBedrooms;
        $jProperty->rooms = $iRooms;
        $jProperty->images = $aImages;

        filePutContents($jData, $sJSONFilePath);


        
    }

    // echo '{"status": 1, "message": "property updated", "line":'. __LINE__.'}';
}
}
