<?php

// STORE INFO ABOUT JSON-FILE IN VARIABLES 
$sDataFileName = 'data.json';
$sJSONFilePath = __DIR__."/data/$sDataFileName";

// GET CONTENT FROM FILE INTO STRING
$sjData = file_get_contents($sJSONFilePath);
// DECODE INTO JSON OBJECT
$jData = json_decode($sjData);


function sendErrorMessage($sErrorMessage, $iLineNumber){ // fetching the 2 arguments and giving them a variable name
    echo '{"status":0, "message":"'.$sErrorMessage.'", "line":'.$iLineNumber.'}';
    exit;
}

function filePutContents($jData, $sJSONFilePath){
    $sjData = json_encode($jData, JSON_PRETTY_PRINT);
    file_put_contents($sJSONFilePath, $sjData);
}

// function getPostalCodes(){
//     $jPostalCodes = new stdClass();
//     $aCoordinates = [];

// }