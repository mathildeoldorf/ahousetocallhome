<?php
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
    /*************************************************************************************/
    // DOCUMENT VARIABLES

    $sUsertype = $_POST['selectUserType'];
    $sFirstName = $_POST['txtFirstName'];
    $sLastName = $_POST['txtLastName'];
    $sEmail = $_POST['txtEmail'];
    $sPassword = $_POST['txtPassword'];
    $sPasswordConfirmation = $_POST['txtPasswordConfirmation'];
    $sImage = $_FILES['image'];

    // GET INFO FROM IMAGE OBJECT AND PROCESS 
    $sUniqueImageName = 'I' . uniqid(); // generating a unique id
    $sExtension = pathinfo($sImage['name'], PATHINFO_EXTENSION); // getting extension
    $sExtension = strtolower($sExtension); // convert to lowercase

    $sImageFileName = "$sUniqueImageName.$sExtension"; // giving a unique filename // or it could be $_FILES[imgProperty]['name'].$sExtension (will be the original name of the file)
    $sFileSize = $sImage['size'];
    $sTempFilePath = $sImage['tmp_name'];

    if ($sUsertype == 'selectAgent') {
        $sFilePath = __DIR__ . "/../images/agents/$sImageFileName";
    }

    if ($sUsertype == 'selectUser') {
        $sFilePath = __DIR__ . "/../images/users/$sImageFileName";
    }

    // MOVE IMAGE INTO IMAGE FOLDER - // 2 arguments: 1) The temporary file [][] <-- a multidimensional associative array , 2) Path of the destination
    move_uploaded_file($sTempFilePath, $sFilePath);

    // SET NEW USER TO VERIFICATION STATUS 0
    $sVerificationStatus = 0;

    // GENERATE UNIQUE ACTIVATION CODE
    $sActivationKey = bin2hex(random_bytes(16));

    /*************************************************************************************/
    // DEFENSIVE CODING

    /****************************************/
    // FIRST NAME 

    //EMPTY 
    if (empty($sFirstName)) {
        sendErrorMessage('variable name [txtFirstName] is missing', __LINE__); //passing 2 arguments
        exit;
    }

    // LENGTH 
    if (strlen($sFirstName) < 2 || strlen($sFirstName) > 20) {
        sendErrorMessage('variable name [txtFirstName] is invalid. Min. 2 and max. 30 characters.', __LINE__);
        exit;
    }

    /****************************************/
    // LAST NAME

    //EMPTY 
    if (empty($sLastName)) {
        sendErrorMessage('variable name [txtLastName] is missing', __LINE__); //passing 2 arguments
        exit;
    }

    // LENGTH 
    if (strlen($sLastName) < 2 || strlen($sLastName) > 20) {
        sendErrorMessage('variable name [txtLastName] is invalid. Min. 2 and max. 30 characters.', __LINE__);
        exit;
    }

    /****************************************/
    // EMAIL

    // EMPTY 
    if (empty($sEmail)) {
        sendErrorMessage('variable email [txtEmail] is missing', __LINE__);
        exit;
    }

    // EMAIL VALIDATION - filter var FILTER_EMAIL
    if (!filter_var($sEmail, FILTER_VALIDATE_EMAIL)) {
        sendErrorMessage('email is not valid', __LINE__);
        exit;
    }

    /****************************************/
    // IMAGE // 

    // EMPTY 
    if (empty($sImage['name'])) {
        sendErrorMessage('variable image [image] is missing', __LINE__);
        exit;
    }

    // // FILETYPE
    $allowedFileExtension = ['png', 'jpg', 'jpeg'];
    if (!in_array($sExtension, $allowedFileExtension)) {
        sendErrorMessage('variable image [image] is not a valid filetype. The file must be JPG JPEG or PNG', __LINE__);
        exit;
    }

    // IMAGE SIZE
    if ($sFileSize < 20480) { //calculated in bytes (KB = 1024 B)
        sendErrorMessage('the file size of variable image [image] is too small. Min. size is 20KB', __LINE__);
        exit;
    }

    if ($sFileSize > 5242880) {
        sendErrorMessage('the file size of variable image [image] is too large. Max size is 5MB', __LINE__);
        exit;
    }

    // PASSWORD - CONFIRM LENGTH OG MATCH

    // EMPTY 
    if (empty($sPassword)) {
        sendErrorMessage('variable password [txtPassword] is missing', __LINE__);
        exit;
    }

    // STRING
    if (strlen($sPassword) < 8 || strlen($sPassword) > 25) {
        sendErrorMessage('variable password [txtPassword] must be between 8 and 25 characters or digits', __LINE__);
        exit;
    }

    // CONFIRMATION
    if ($sPasswordConfirmation != $sPassword) {
        sendErrorMessage('variable password and password confirmation [txtPassword] [txtPasswordConfirmation] does not match', __LINE__);
        exit;
    }

    /************************************************************************/
    // AGENT

    if ($sUsertype == 'selectAgent') {
        // POINT TO THE NESTED JSON OBJECT AGENTS
        $jUsers = $jData->agents;

        // CREATE UNIQUE ID
        $sUniqueId = uniqid();

        // CREATE A NEW NESTED JSON OBJECT FOR AGENT
        $jUser = new stdClass();

        // POPULATE THE NEW JSON OBJECT WITH DATA
        $jUser->userId = $sUniqueId;
        $jUser->userType = $sUsertype;
        $jUser->firstName = $sFirstName;
        $jUser->lastName = $sLastName;
        $jUser->email = $sEmail;
        $jUser->image = $sImageFileName;
        $jUser->password = $sPassword;
        $jUser->passwordConfirmation = $sPasswordConfirmation;
        $jUser->email = $sEmail;
        $jUser->verification = $sVerificationStatus;
        $jUser->activationKey = $sActivationKey;

        // CREATE A NEW NESTED JSON OBJECT FOR PROPERTIES
        $jUser->properties = new stdClass();

        $jUser->favorites = new stdClass();

        $jUsers->$sUniqueId = $jUser;
    }

    /************************************************************************/
    // USER

    if ($sUsertype == 'selectUser') {
        // POINT TO THE NESTED JSON OBJECT AGENTS
        $jUsers = $jData->users;

        // CREATE UNIQUE ID
        $sUniqueId = uniqid();

        // CREATE A NEW NESTED JSON OBJECT FOR AGENT
        $jUser = new stdClass();

        // POPULATE THE NEW JSON OBJECT WITH DATA
        $jUser->userId = $sUniqueId;
        $jUser->userType = $sUsertype;
        $jUser->firstName = $sFirstName;
        $jUser->lastName = $sLastName;
        $jUser->email = $sEmail;
        $jUser->image = $sImageFileName;
        $jUser->password = $sPassword;
        $jUser->passwordConfirmation = $sPasswordConfirmation;
        $jUser->email = $sEmail;
        $jUser->verification = $sVerificationStatus;
        $jUser->activationKey = $sActivationKey;

        $jUsers->$sUniqueId = $jUser;
    }

    // $sjData = json_encode( $jData , JSON_PRETTY_PRINT ); // convert JSON to text
    filePutContents($jData, $sJSONFilePath);



    // EMAIL

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
        $mail->addAddress($sEmail, 'cred');     // Add a recipient

        // Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML

        $sPath = "path&id=$sUniqueId&key=$sActivationKey";

        $mail->Subject = 'Welcome! Please verify your account';
        $mail->Body    = '<h1>Welcome!</h1> <a href="' . $sPath . '">Please click here to verify your account</a>';
        $mail->AltBody = 'Welcome. Please follow this link to verify your account: ' . $sPath . '';

        $mail->send();
        echo json_encode('success');
        exit;
    } catch (Exception $e) {
        echo json_encode("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        exit;
    }
}
