<?php 
session_start();

// REQUIRE FUNCTIONS.PHP TO RUN ERROR-FUNCTION AND GET CONTENTS OF DATA.JSON AND DECODE INTO A JSON-OBJECT
require_once(__DIR__.'/functions.php'); 

$sUserType = $_SESSION['sUserType'];
$sUserId = $_SESSION['sUserId'];

unset($jData->$sUserType->$sUserId);

//FOR DEACTIVATION
// $jLoggedUser = $jData->$sUserType->$sUserId; 
// $jLoggedUser->verification = 0;

filePutContents($jData, $sJSONFilePath);


session_destroy();
header('Location: signup.php');

?>