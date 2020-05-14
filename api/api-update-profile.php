<?php

session_start();

if(!$_SESSION){
    header('Location: login.php');
    exit;
}

if($_SESSION){
    if($_POST){

        // REQUIRE FUNCTIONS.PHP TO RUN ERROR-FUNCTION AND GET CONTENTS OF DATA.JSON AND DECODE INTO A JSON-OBJECT
        require_once(__DIR__.'/../functions.php'); 

        // GET INFORMATION FROM SESSION TO POINT TO THE CORRECT USER IN THE CORRECT NESTED OBJECT (USERS / AGENTS)
        $sUserType = $_SESSION['sUserType'];
        $sUserId = $_SESSION['sUserId'];

        // POINT TO THE USER IN SESSION
        $jLoggedUser = $jData->$sUserType->$sUserId;

        $imageName = $jLoggedUser->image;
    
        // VALIDATE THE DATA BEFORE PASSING IT - email, string length

        // GET DATA FROM POST THROUGH AJAX
        $sNewFirstName = $_POST['txtFirstName'];
        $sNewLastName = $_POST['txtLastName'];
        $sNewEmail = $_POST['txtEmail'];
        $sNewPassword = $_POST['txtPassword'];
        $sNewImage = $_FILES['fImage'];

        // GET INFO FROM IMAGE OBJECT AND PROCESS 
        $sUniqueImageName = 'I'.uniqid(); // generating a unique id
        $sExtension = pathinfo($sNewImage['name'], PATHINFO_EXTENSION); // getting extension
        $sExtension = strtolower($sExtension); // convert to lowercase

        $sImageFileName = "$sUniqueImageName.$sExtension"; // giving a unique filename // or it could be $_FILES[imgProperty]['name'].$sExtension (will be the original name of the file)
        $sFileSize = $sNewImage['size'];
        $sTempFilePath = $sNewImage['tmp_name'];
    
        $sFilePath = __DIR__."/../images/$sUserType/$sImageFileName";

        // MOVE IMAGE INTO IMAGE FOLDER - // 2 arguments: 1) The temporary file [][] <-- a multidimensional associative array , 2) Path of the destination
        move_uploaded_file($sTempFilePath, $sFilePath);

        //UPDATE DATA IN THE RIGHT PATH IN THE DATABASE
        $jLoggedUser->firstName = $sNewFirstName;
        $jLoggedUser->lastName = $sNewLastName;
        $jLoggedUser->email = $sNewEmail;
        $jLoggedUser->password = $sNewPassword;
        $jLoggedUser->image = $sImageFileName;

        // PUT INTO DATABASE

        filePutContents($jData, $sJSONFilePath);

        echo '{"status": 1, "message": "user updated", "line":'. __LINE__.'}';
    }
}




