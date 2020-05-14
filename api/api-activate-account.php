<?php

//CHECK IF ID AND KEY EXISTS IN DATA.JSON?
// SESSION?
// WHAT ELSE?

// CHECK NOT ID IN DATABASE WORKING

// REQUIRE FUNCTIONS.PHP TO RUN ERROR-FUNCTION AND GET CONTENTS OF DATA.JSON AND DECODE INTO A JSON-OBJECT
require_once(__DIR__.'/../functions.php'); 

/*************************************************************************************/
// DOCUMENT VARIABLES
$regExPatternId = "/\w{13,13}$/";
$regExPatternKey = "/\w{32,32}$/";

/*************************************************************************************/
// DEFENSIVE CODING

// // GET ID, ACTIVATIONKEY AND VERIFICATION STATUS FROM GET THROUGH SEND-EMAIL-ACTIVATION API
$sAction = $_GET['action'];
$sActivationKey = $_GET['key'];
$sUserId = $_GET['id'];
$bValidation = true;

/****************************************/
// REGEX

// CHECK THAT THE ID IS VALID - WITH REG EX - LENGTH AND CHARACTERTYPES
if(!preg_match($regExPatternId, $sUserId) && $bValidation===true ){
    $bValidation = false;
    sendErrorMessage('Match not found for variable AgentId!',__LINE__); //passing 2 arguments
   
}

// CHECK THAT THE KEY IS VALID - WITH REG EX - LENGTH AND CHARACTERTYPES
if(!preg_match($regExPatternKey, $sActivationKey) && $bValidation===true){
    $bValidation = false;
    sendErrorMessage('Match not found for variable AgentId!',__LINE__); //passing 2 arguments
}

// // IF ID DOESN'T EXIST IN THE DATABASE

if (!property_exists($jData->agents, $sUserId) && !property_exists($jData->users, $sUserId) && $bValidation===true) {
    $bValidation = false;
}

if($bValidation===true){
// GET THE VERIFICATION STATUS + ACTIVATION KEY FOR THE GET ID 

if (property_exists($jData->agents, $sUserId)) {
    $jUser = $jData->agents->$sUserId;
} else {
    $jUser = $jData->users->$sUserId;
}

$sVerificationStatus = $jUser->verification;
$sUserActivationKey = $jUser->activationKey;

/****************************************/
// VERIFICATION STATUS

// IF VERIFIED 
if($sVerificationStatus == 1){?>
    <div id="verify" class="bg-blue grid one-column-grid ja-items-center">
    <h1>Hi, <?= $jUser->firstName ?></h1><h2>Your account is already verified. Proceed to login.</h2>
    </div>
    <script>
        setTimeout(function(){
        $('#verify').hide();
        }, 2000);
    </script>

    <?php
    $bValidation = false;
}

// IF ACTIVATIONKEY IS NOT CORRECT ACCORDING TO USER ID 
if($sUserActivationKey != $sActivationKey && $bValidation===true){
    sendErrorMessage('You are not authorized', __LINE__);
    $bValidation = false;
}

    if($bValidation === true){?>    
    <div id="verify" class="bg-blue grid one-column-grid ja-items-center">
        <h1>Welcome, <?= $jUser->firstName ?></h1> <h2>Your account is verified</h2>
    </div>

    <script>
        setTimeout(function(){
        $('#verify').hide();
        }, 2000);
    </script>



<?php
        $jUser->verification = 1;

        $sjData = json_encode($jData, JSON_PRETTY_PRINT);

        file_put_contents(__DIR__."/../data/$sDataFileName", $sjData);

    }
}


?>
