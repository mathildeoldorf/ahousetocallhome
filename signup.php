<?php

session_start();

if($_SESSION){
    header('Location: profile.php');
    exit;
}

$sTitle = 'Signup';
$sScriptPath = 'js/signup.js';

require_once(__DIR__.'/components/header.php'); ?>

<section class="signup-container full-view-width full-view-height ja-items-center grid text-center bg-cover" style="background-image: url(images/background.jpg);">
    
<form class="signup bg-blue grid one-column-grid" method="POST">
<h1 class="text-center">Signup</h1>
    
<select name="selectUserType" id="selectUserType">
    <option value="selectAgent">Agent</option>
    <option value="selectUser">User</option>
</select>
    <div>
    <input class="full-width" name="image" type="file" placeholder="Image">
    <div class="button overlay-layer">Upload photo</div>
    </div>
    <input class="full-width" name="txtFirstName" type="text" placeholder="First Name (2-20 characters)" type="text" maxlength="20" data-type="string" data-min="2" data-max="20" value="Mathias">
    <input class="full-width" name="txtLastName" type="text" placeholder="Last Name (2-20 characters)" type="text" maxlength="20" data-type="string" data-min="2" data-max="20" value="Levin">
    <input class="full-width" name="txtEmail" type="text" placeholder="Email (you@something.com)" type="text" maxlength="30" data-type="string" data-min="2" data-max="20" value="mail@mail.com">
    <input class="full-width" name="txtPassword" type="password" placeholder="Password">
    <input class="full-width" name="txtPasswordConfirmation" type="password" placeholder="Password Confirmation">
    <button class="button full-width bg-black">Signup</button>
</form>
</section>



<?php require_once(__DIR__.'/components/footer.php'); ?>