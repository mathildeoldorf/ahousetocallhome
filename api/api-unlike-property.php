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

$jLoggedUser = $jData->$sUserType->$sUserId;

$aFavorites = $jLoggedUser->favorites;

foreach (array_keys($aFavorites, $sPropertyId) as $key => $sProperty) {

    unset($aFavorites[$sProperty]);
}

$jData->$sUserType->$sUserId->favorites = $aFavorites;

$sjData = json_encode( $jData , JSON_PRETTY_PRINT ); // convert JSON to text
filePutContents($jData, $sJSONFilePath);

// echo $sPropertyId;
