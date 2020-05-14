<?php 
session_start();

// REQUIRE FUNCTIONS.PHP TO RUN ERROR-FUNCTION AND GET CONTENTS OF DATA.JSON AND DECODE INTO A JSON-OBJECT
require_once(__DIR__.'/functions.php'); 

$sPropertyId = $_SESSION['sPropertyId'];
$sUserId = $_SESSION['sUserId'];

// unset($jData->agents->$sAgentIdForProperty->$sPropertyId);

//FOR DEACTIVATION
$jCurrentProperty = $jData->agents->$sUserId->properties->$sPropertyId; 
$jCurrentProperty->verification = 0;

filePutContents($jData, $sJSONFilePath);

header('Location: profile.php');

?>