<?php
session_start();

if(!$_SESSION){
    exit;
}

// REQUIRE FUNCTIONS.PHP TO RUN ERROR-FUNCTION AND GET CONTENTS OF DATA.JSON AND DECODE INTO A JSON-OBJECT
require_once(__DIR__.'/../functions.php'); 

// GET INFORMATION FROM SESSION TO POINT TO THE CORRECT USER IN THE CORRECT NESTED OBJECT (USERS / AGENTS)
$sUserType = $_SESSION['sUserType'];
$sUserId = $_SESSION['sUserId'];
$sPropertyId = $_SESSION['sPropertyId'];
$sAgentId = $_SESSION['sAgentId'];

// POINT TO THE USER IN SESSION
$jLoggedUser = $jData->$sUserType->$sUserId;

$aFavorites = $jLoggedUser->favorites;

if($aFavorites == $sPropertyId){
    sendErrorMessage('Already a favorite',__LINE__);
    exit;
}

array_push($aFavorites, $sPropertyId);

$jData->$sUserType->$sUserId->favorites = $aFavorites;

$sjData = json_encode( $jData , JSON_PRETTY_PRINT ); // convert JSON to text
filePutContents($jData, $sJSONFilePath);

echo json_encode($sPropertyId);


