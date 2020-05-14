<?php 

session_start();

if(!$_SESSION){
    header('Location: login.php');
    exit;
}

if($_SESSION){
// REQUIRE FUNCTIONS.PHP TO RUN ERROR-FUNCTION AND GET CONTENTS OF DATA.JSON AND DECODE INTO A JSON-OBJECT
require_once(__DIR__.'/functions.php'); 

// GET INFORMATION FROM SESSION TO POINT TO THE CORRECT USER IN THE CORRECT NESTED OBJECT (USERS / AGENTS)
$sUserType = $_SESSION['sUserType'];
$sUserId = $_SESSION['sUserId'];

// POINT TO THE USER IN SESSION TO GET ALL INFO
$jLoggedUser = $jData->$sUserType->$sUserId;

// TITLE AND SCRIPT
$sTitle = "Update profile | $jLoggedUser->firstName";
// $sScriptPath = 'js/update-profile.js';

// POINT TO THE USER IN SESSION TO GET ALL INFO

$imageName = $jLoggedUser->image;
$sFirstName = $jLoggedUser->firstName;
$sLastName = $jLoggedUser->lastName;
$sEmail = $jLoggedUser->email;
$sPassword = $jLoggedUser->password;

// GET THE NAMES OF THE FIELDS
$aFields = ['First name', 'Last name', 'Email', 'Password'];

require_once(__DIR__.'/components/header.php'); 

echo "Hi $sUserId $jLoggedUser->firstName";
}
?>

<section id="update-profile">
    <div class="profile-container grid two-column-grid-always ja-items-center">
    <div class="profile-image bg-cover" style="background-image: url('images/<?=$sUserType?>/<?=$imageName?>')"></div>
    <form class="eighty-width grid" id="<?= $sUserId; ?>" class="update-profile" action="" method="POST">
            
            <input id="fileNewImage" type="file" name="fImage">
            <div class="button overlay-layer">Upload photo</div>
            <div class="profile-info">
                <h3 class="Name">Name</h3>
                <div class="Name grid two-column-grid-always">
                    <input id="txtNewFirstName" type="text" name="txtFirstName" value="<?= $sFirstName ?>">
                    <input id="txtNewLastName" type="text" name="txtLastName" value="<?= $sLastName ?>">
                </div>
            
            <h3 class="Email">Email</h3>
            <input id="txtNewEmail" type="text" name="txtEmail" value="<?= $sEmail ?>">

            <h3 class="Password">Password</h3>
            <input id="txtNewPassword" type="password" name="txtPassword" value="<?= $sPassword ?>">
            </div>
            <div class="buttons grid three-column-grid">
                <a href="profile.php" class="button">GO BACK</a>
                <a href="delete.php" class="button">DELETE</a>
                <a href="" id="updateBtn" class="button">SAVE</a>
                </div>
          
        </form>
    </div>
    <a class="button" href="logout.php">Logout</a>
</section>

<?php require_once(__DIR__.'/components/footer.php'); ?>


