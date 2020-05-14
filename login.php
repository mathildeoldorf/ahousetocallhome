<?php session_start();
// if(form submitted) { handle data and redirect+exit if successful } show form; if it has been submitted populate it with the submitted values

if ($_SESSION) { 
  header('Location: profile.php'); 
  exit;
} 

// REQUIRE THE API AGENT ACTIVATE PROFILE TO RUN ON THE PAGE
if (isset($_GET['action']) && $_GET['action'] === 'verify' && isset($_GET['key']) && isset($_GET['id'])) {
  // REQUIRE FUNCTIONS.PHP TO RUN ERROR-FUNCTION AND GET CONTENTS OF DATA.JSON AND DECODE INTO A JSON-OBJECT
  require_once(__DIR__.'/functions.php'); 
  require_once(__DIR__.'/api/api-activate-account.php');
}
  
if(!$_SESSION){
  // REQUIRE FUNCTIONS.PHP TO RUN ERROR-FUNCTION AND GET CONTENTS OF DATA.JSON AND DECODE INTO A JSON-OBJECT
  require_once(__DIR__.'/functions.php'); 

  if ($_POST) {
    // POINT TO THE NESTED JSON OBJECT AGENTS
    $jAgents = $jData->agents;
    $jUsers = $jData->users;
    $sUsertype = $_POST['selectUserType'];
    $sEmail = $_POST['txtEmail'];
    $sPassword = $_POST['txtPassword'];

    if($sUsertype == 'selectAgent'){
    foreach ($jAgents as $sAgentId => $jAgent) {
      $sAgentEmail = $jAgent->email;
      $sAgentPassword = $jAgent->password;
      $sVerificationStatus = $jAgent->verification;

      if ($sAgentEmail == $sEmail && $sAgentPassword == $sPassword && $sVerificationStatus == 1) {
        $_SESSION['sUserId'] = $sAgentId;
        $_SESSION['sUserType'] = 'agents';

        header('Location: profile.php');
        exit;
      }
    }
        $sTitle = 'Login'; 
        require_once(__DIR__.'/components/header.php'); 
        echo '
        <section id="login-container" class="full-view-width full-view-height ja-items-center grid text-center bg-cover" style="background-image: url(images/background.jpg);">
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
          </form>
        </section>';
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
        header('Location: profile.php');
        exit;
      }
    }

        $sTitle = 'Login'; 
        require_once(__DIR__.'/components/header.php'); 
        echo '
        <section id="login-container" class="full-view-width full-view-height ja-items-center grid text-center bg-cover" style="background-image: url(images/background.jpg);">
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
           </form>
           </section>';
            exit;
  }
} 
}

$sTitle = 'Login'; 
require_once(__DIR__.'/components/header.php'); ?>

<section id="login-container" class="full-view-width full-view-height ja-items-center grid text-center bg-cover" style="background-image: url(images/background.jpg);">
 <form class="login bg-blue grid one-column-grid" method="POST">
 <h1 class="color-white">Welcome | Login</h1>
  <select name="selectUserType" id="selectUserType">
    <option value="selectAgent">Agent</option>
    <option value="selectUser">User</option>
  </select>
   <input name="txtEmail" type="text" placeholder="Email">
   <input name="txtPassword" type="password" placeholder="Password">
   <button class="button">LOGIN</button>
 </form>
 </section>
 
<?php require_once(__DIR__.'/components/footer.php'); ?>

 
 