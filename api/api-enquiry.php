<?php

session_start();

if (!$_SESSION) {
    exit;
}

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Require files from PHPMailer
require __DIR__ . '/PHPMailer/PHPMailer.php';
require __DIR__ . '/PHPMailer/Exception.php';
require __DIR__ . '/PHPMailer/SMTP.php';

// REQUIRE FUNCTIONS.PHP TO RUN ERROR-FUNCTION AND GET CONTENTS OF DATA.JSON AND DECODE INTO A JSON-OBJECT
require_once(__DIR__ . '/../functions.php');

// IF THE USER HAS POSTED - GET INPUT THROUGH POST
if ($_POST) {

    // GET INFORMATION FROM SESSION TO POINT TO THE CORRECT USER IN THE CORRECT NESTED OBJECT (USERS / AGENTS)
    $sUserType = $_SESSION['sUserType'];
    $sUserId = $_SESSION['sUserId'];
    $sPropertyId = $_SESSION['sPropertyId'];
    $sAgentId = $_SESSION['sAgentId'];

    $sEnquiry = $_POST['txtEnquiry'];

    // if($sUserType != 'users'){
    //     exit;
    // }

    // POINT TO THE USER IN SESSION
    $jLoggedUser = $jData->$sUserType->$sUserId;

    $sFirstName = $jLoggedUser->firstName;
    $sLastName = $jLoggedUser->lastName;
    $sEmail = $jLoggedUser->email;

    $jAgent = $jData->agents->$sAgentId;

    $jAgentEmail = $jAgent->email;
    $jAgentFirstName = $jAgent->firstName;
    $jAgentLastName = $jAgent->lastName;


    // // EMAIL

    // Instantiation and passing `true` enables exceptions/errors
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'cred';                     // SMTP username
        $mail->Password   = 'cred';                               // SMTP password
        $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('cred', 'cred');
        $mail->addAddress('cred', 'cred');     // Add a recipient

        // Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML

        $sPath = "path?id=$sPropertyId";

        $mail->Subject = "Hello $jAgentFirstName $jAgentLastName. You have a new enquiry!";
        $mail->Body    = "<h1>Hello! $jAgentFirstName $jAgentLastName. You have a new enquiry</h1> <h2>$sFirstName $sLastName:</h2>$sEnquiry.<br> <h2>Contact $sFirstName $sLastName:</h2> <p>Email: $sEmail</p> <a href='$sPath'>Please click here to view the listingt</a>";
        $mail->AltBody = 'Welcome. Please follow this link to verify your account: ' . $sPath . '';

        $mail->send();
        echo '{success}';
        header('Location: ../property.php?id=' . $sPropertyId . '');
        exit;
    } catch (Exception $e) {
        echo json_encode("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        exit;
    }
}
