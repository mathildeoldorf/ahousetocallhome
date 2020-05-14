<?php

session_start();

if(!$_SESSION){
    // header('Location: login.php');
    exit;
}

if($_SESSION){

$sTitle = 'Property';

// GET USERTYPE FROM SESSION
$sPropertyId = $_GET['id'];
$_SESSION['sPropertyId'] = $sPropertyId;
$sUserType = $_SESSION['sUserType'];
$sUserId = $_SESSION['sUserId'];

require_once(__DIR__.'/functions.php'); 
require_once(__DIR__.'/components/header.php'); 

$jLoggedUser = $jData->$sUserType->$sUserId;
$jAgents = $jData->agents; 

foreach ($jAgents as $sAgentId => $jAgent) {
    
    $jAgentProperties = $jAgent->properties;

    foreach ($jAgentProperties as $sAgentPropertyId => $jAgentProperty) {

        if($sAgentPropertyId == $sPropertyId){ 
            $_SESSION['sAgentId'] = $sAgentId;

            // GET VERIFICATION STATUS FOR PROPERTY AND STORE IN SESSION
            $sPropertyVerification = $jAgentProperty->verification;
            if($sPropertyVerification == 1){

                if($sUserType == 'agents'){
                $sScriptPath = 'js/update-property.js';
                
                require_once(__DIR__.'/api/api-update-property.php'); 
                require_once(__DIR__.'/components/property-agents.php');
                require_once(__DIR__.'/components/footer.php'); 
                
                
                }

                if($sUserType == 'users'){
                    $jLoggedUserFavorites = $jLoggedUser->favorites;
                    

                    require_once(__DIR__.'/components/property-users.php');
                    require_once(__DIR__.'/components/footer.php'); 

                    echo '<script>';
                    require_once(__DIR__.'/js/like.js');
                    echo'</script>'; 

                    echo '<script>';
                    require_once(__DIR__.'/js/enquiry.js');
                    echo'</script>'; 
                    
                    
                }
            
     }
    else{
        header('Location: index.php');
        exit;
    }
    }
    

    }

}


}?>