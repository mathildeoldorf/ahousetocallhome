<?php session_start(); //Start your memory
if(!$_SESSION){
    header('Location: login.php');
    exit;
}

if ($_SESSION) {
// REQUIRE FUNCTIONS.PHP TO RUN ERROR-FUNCTION AND GET CONTENTS OF DATA.JSON AND DECODE INTO A JSON-OBJECT
require_once(__DIR__.'/functions.php'); 


// GET INFORMATION FROM SESSION TO POINT TO THE CORRECT USER IN THE CORRECT NESTED OBJECT (USERS / AGENTS)
$sUserType = $_SESSION['sUserType'];
$sUserId = $_SESSION['sUserId'];

// POINT TO THE USER IN SESSION
$jLoggedUser = $jData->$sUserType->$sUserId;
$sTitle = "Profile | $jLoggedUser->firstName";
$sScriptPath = 'js/profile.js';

require_once(__DIR__.'/components/header.php');

$imageName = $jLoggedUser->image;
$sFirstName = $jLoggedUser->firstName;
$sLastName = $jLoggedUser->lastName;
$sEmail = $jLoggedUser->email;
$sPassword = $jLoggedUser->password;?>

<section id="profile">
    <div class="profile-container grid two-column-grid ja-items-center">
        <div class="profile-image bg-cover" style="background-image: url('images/<?=$sUserType?>/<?=$imageName?>')"></div>
        <div class="profile-info-container eighty-width grid">
            <div class="profile-info">
                <h1>Hi <?=$sFirstName.' '. $sLastName;?></h1>
                <h3 class="Email">Email</h3>
                <p class="email"><?= $sEmail; ?></p>
            </div>
            <div class="buttons grid four-column-grid">
                    <a id="updateProfileBtn" class="button" href="">UPDATE</a>
                    <a class="button" href="delete.php">DELETE</a>
                    <?php if($sUserType == 'agents'){?>
                    <a class="button" href="mailto: <?= $sEmail; ?>">CONTACT</a>
                    <a id="createPropertyBtn" class="button" href="">Create property</a>
                    <?php } ?>
            </div>
        </div>
    </div>
</section>

<?php if($sUserType == 'users'){ 
    $jLoggedUserFavorites = $jLoggedUser->favorites;    
    $jAgents = $jData->agents; 
    // $aProperties = [];
?>


<section id="favorites">
<h2 class="text-center">Your favorites</h2>

<div class="favorites-container grid three-column-grid">
    
<?php
    foreach ($jAgents as $sAgentId => $jAgent) {
        $jAgentProperties = $jAgent->properties;

        foreach($jAgentProperties as $sAgentPropertyId => $jAgentProperty){
            if($jAgentProperty->verification != 0){

                foreach ($jLoggedUserFavorites as $jLoggedUserFavorite) {

                    if($sAgentPropertyId == $jLoggedUserFavorite){?>

                    <div class="property relative">
                            <div class="image bg-cover" style="background-image: url('images/properties/<?= $jAgentProperty->images[0]?>')"></div>
                            <div class="property-overlay details grid five-column-grid full-width full-height absolute full-width full-height">
                                <h3 class="address uppercase"><?= $jAgentProperty->address->street.' '.$jAgentProperty->address->streetnumber;?></h3> 
                                <h3 class="address uppercase"><?= $jAgentProperty->address->postalcode.' '.$jAgentProperty->address->city; ?></h3>
                                <h3 class="address uppercase"><?=$jAgentProperty->price ?> kr</h3>
                            </div>
                            <a class="button relative" href="property.php?id=<?= $sAgentPropertyId; ?>">View property</a>
                        </div>
                <?php 
                    }
                }
            }
        }
    }

        
?>

</section>

<?php } ?>

<?php if($sUserType == 'agents'){
require_once(__DIR__.'/api/api-create-property.php');    
?>

<section id="agent-properties" class="">
<h2 class="text-center">Your properties</h2>

<div class="properties-container grid three-column-grid">
<?php $jProperties = $jData->$sUserType->$sUserId->properties;

foreach($jProperties as $sPropertyId => $jProperty){

    $iPropertyVerificationStatus = $jProperty->verification;

    if($iPropertyVerificationStatus == 1){?>

    

    <div class="property relative">
        <div class="image bg-cover" style="background-image: url('images/properties/<?= $jProperty->images[0]?>')"></div>
        <div class="property-overlay details grid five-column-grid full-width full-height absolute full-width full-height">
            <h3 class="address uppercase"><?= $jProperty->address->street.' '.$jProperty->address->streetnumber;?></h3> 
            <h3 class="address uppercase"><?= $jProperty->address->postalcode.' '.$jProperty->address->city; ?></h3>
            <h3 class="address uppercase"><?=$jProperty->price ?> kr</h3>
        </div>
        <a class="button relative" href="property.php?id=<?= $sPropertyId; ?>">View property</a>
    </div>

    <?php } 
    }?>
</div>

</section>

<section id="create-property-form" class="ja-items-center grid absolute">
    
    <form class="create-property bg-blue grid one-column-grid" method="POST" enctype="multipart/form-data">
    <a href="" class="close"> </a>
    <h1 class="text-center">Create property</h1>
    <div>
            <input id="images" name="images[]" type="file" placeholder="Images (Max. 4)" multiple>
            <div class="button overlay-layer">Upload photos</div>
        </div>
        <div class="create-property-input-container grid two-column-grid-always">
        
        <input class="full-width" name="txtStreet" type="text" placeholder="Street (2-20 characters)" type="text" maxlength="20" data-type="string" data-min="2" data-max="20" value="">
        <input class="full-width" name="iStreetNumber" type="text" placeholder="Street number (1-5 characters)" type="text" maxlength="10" data-type="string" data-min="1" data-max="5" value="">
        <input class="full-width" name="iPostalCode" type="text" placeholder="Postal code (4 digits)" type="text" maxlength="4" data-type="string" data-min="4" data-max="4" value="">
        <input class="full-width" name="sCity" type="text" placeholder="City (2-30 character)" type="text" maxlength="30" data-type="string" data-min="2" data-max="30" value="">
        <input class="full-width" name="iPrice" type="text" placeholder="Price" maxlength="10" data-type="string" data-min="5" data-max="10" value="">
        <input class="full-width" name="iSize" type="text" placeholder="Size (Numbers only)" maxlength="4" data-type="string" data-min="2" data-max="4" value="">
        <input class="full-width" name="iBedrooms" type="text" placeholder="Bedrooms (Numbers only)" maxlength="4" data-type="string" data-min="2" data-max="4" value="">
        <input class="full-width" name="iRooms" type="text" placeholder="Rooms (Numbers only)" maxlength="4" data-type="string" data-min="2" data-max="4" value="">
        </div>
        <input class="full-width" name="txtDescription" type="text" placeholder="Description" maxlength="100" data-type="string" data-min="20" data-max="100" value="">
        <button id="createPropertyFormBtn" class="full-width button">Create property</button>
       
    </form>
</section>

<section id="update-profile-form" class="ja-items-center grid absolute">
<a href="" class="close"> </a>
    <form class="update-profile bg-blue grid one-column-grid" id="<?= $sUserId; ?>" class="update-profile" method="POST">
        <div>
            <input id="fileNewImage" type="file" name="fImage">
            <div class="button overlay-layer">Upload photo</div>
        <div>
        <h3 class="Name">Name</h3>
            <div class="create-property-input-container grid">   
            
            <div class="profile-info two-column-grid-always grid">
                
                
                    <input id="txtNewFirstName" type="text" name="txtFirstName" value="<?= $sFirstName ?>">
                    <input id="txtNewLastName" type="text" name="txtLastName" value="<?= $sLastName ?>">
                
            
            <h3 class="Email">Email</h3>
            <input id="txtNewEmail" type="text" name="txtEmail" value="<?= $sEmail ?>">

            <h3 class="Password">Password</h3>
            <input id="txtNewPassword" type="password" name="txtPassword" value="<?= $sPassword ?>">
            </div>
</div>
            <div class="buttons grid three-column-grid">
                <a href="profile.php" class="button">GO BACK</a>
                <a href="delete.php" class="button">DELETE</a>
                <a href="" id="updateBtn" class="button">SAVE</a>
                </div>
          
        </form>
    </div>
</section>

<?php } ?>

<?php require_once(__DIR__.'/components/footer.php');
} ?>


