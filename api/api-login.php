<?php
session_start();

// REQUIRE FUNCTIONS.PHP TO RUN ERROR-FUNCTION AND GET CONTENTS OF DATA.JSON AND DECODE INTO A JSON-OBJECT
require_once(__DIR__.'/../functions.php'); 
// POINT TO THE NESTED JSON OBJECT AGENTS
$jAgents = $jData->agents;
$jUsers = $jData->users;
$sUsertype = $_POST['selectUserType'];
$sEmail = $_POST['txtEmail'];
$sPassword = $_POST['txtPassword'];
echo 'posted';

echo $sUsertype;
    
    if($sUsertype == 'selectAgent'){
        foreach ($jAgents as $sAgentId => $jAgent) {
        $sAgentEmail = $jAgent->email;
        $sAgentPassword = $jAgent->password;
        $sVerificationStatus = $jAgent->verification;
    
            if ($sAgentEmail == $sEmail && $sAgentPassword == $sPassword && $sVerificationStatus == 1) {
            $_SESSION['sUserId'] = $sAgentId;
            $_SESSION['sUserType'] = 'agents';
            // header('Location: ../profile.php');
            echo $_SESSION['sUserId'];
            exit;
            }
        }
            echo ' 
            <form class="login bg-blue grid one-column-grid" method="POST">
            <h1>Welcome | Login</h1>
            <select name="selectUserType" id="selectUserType">
            <option value="selectAgent">Agent</option>
            <option value="selectUser">User</option>
            </select>
            <p>Credentials are incorrect</p>
            <input name="txtEmail" type="text" placeholder="Email">
            <input name="txtPassword" type="password" placeholder="Password">
            <button class="button">LOGIN</button>
            </form>';
            exit;
    }
    else {
        foreach ($jUsers as $sUserId => $jUser) {
        $sUserEmail = $jUser->email;
        $sUserPassword = $jUser->password;
        $sVerificationStatus = $jUser->verification;
    
            if ($sUserEmail == $sEmail && $sUserPassword == $sPassword && $sVerificationStatus == 1) {
            $_SESSION['sUserId'] = $sUserId;
            $_SESSION['sUserType'] = 'users';
            // header('Location: ../profile.php');
            echo $_SESSION['sUserId'];
            exit;
            }
        }
            echo '
            <form class="login bg-blue grid one-column-grid" method="POST">
            <h1>Welcome | Login</h1>
            <select name="selectUserType" id="selectUserType">
            <option value="selectAgent">Agent</option>
            <option value="selectUser">User</option>
            </select>
            <p>Credentials are incorrect</p>
            <input name="txtEmail" type="text" placeholder="Email">
            <input name="txtPassword" type="password" placeholder="Password">
            <button class="button">LOGIN</button>
            </form>';
            exit;
    }




// TILKNYT PROFIL ID

// if(!$_SESSION){

// if($_POST){

//     $bValidation = false;
//     $jLoggedUserId = '';

//     // POINT TO THE NESTED JSON OBJECT AGENTS
//     $jAgents = $jData->agents;
//     $jUsers = $jData->users;

//     // FOREACH
//     foreach($jAgents as $sUserId => $jAgent){
//         if($_POST['txtEmail'] == $jAgent->email){

//             if($_POST['txtPassword'] == $jAgent->password){
//                 $bValidation = true;
//                 $jLoggedUserId = $sUserId;
//             }
//         }   
    
//     }   

//     if($bValidation === false){
//         foreach($jUsers as $sUserId => $jUser){
//             if($_POST['txtEmail'] == $jUser->email){
    
//                 if($_POST['txtPassword'] == $jUser->password){
//                     $bValidation = true;
//                     $jLoggedUserId = $sUserId;

//                 }
//             }   
//         }  
//     }

//    if($bValidation === true){
//        echo $jLoggedUserId;
//         session_start();
    
//     // EXTRACT ID OF THE AGENT AND STORE IT IN THE SESSION
//     $_SESSION['id'] = $jLoggedUserId;
  
//     echo json_encode('success');

//     header('Location: ../../profile.php?id='.$jLoggedUserId.'');
//     exit;
//     }
// }
// }

// if($bValidation===false){
//     sendErrorMessage('The credentials are invalid',__LINE__);
//     exit;
// } 
