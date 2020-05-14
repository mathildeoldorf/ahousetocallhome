<?php

// THINKS 0 = EMPTY

if(!isset($_GET['search'])){
    echo '[]';
    exit;
}

require_once(__DIR__.'/../functions.php'); 

$sSearchFor = $_GET['search'] ?? ''; // user-input

$jAgents = $jData->agents; 

$aProperties = [];
$aPropertyInfo = [];

    foreach ($jAgents as $sAgentId => $jAgent) {
      $jAgentProperties = $jAgent->properties;

    foreach($jAgentProperties as $sAgentPropertyId => $jAgentProperty){

      if($jAgentProperty->verification != 0){

      $sAgentPropertyPostalCode = $jAgentProperty->address->postalcode;

      if(strpos($sAgentPropertyPostalCode, $sSearchFor) !== false){
        
        array_push($aPropertyInfo, $sAgentPropertyId);
        array_push($aPropertyInfo, $jAgentProperty->images[0]);
        array_push($aProperties, $aPropertyInfo);

        array_splice($aPropertyInfo, 0);
      
        }
      }
    }
  }

echo json_encode($aProperties);


