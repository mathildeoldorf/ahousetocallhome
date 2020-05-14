<?php
if($_SESSION){
$sUserId = $_SESSION['sUserId'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $sTitle; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400&display=swap" rel="stylesheet">

    <script src='https://api.mapbox.com/mapbox-gl-js/v1.2.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.2.0/mapbox-gl.css' rel='stylesheet'>

    <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
    <link rel="manifest" href="images/favicon/site.webmanifest">
    <link rel="mask-icon" href="images/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="images/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="images/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
</head>
<body>
<nav role="navigation">
<a href="index.php"><h2 class="color-black slogan fixed">A house to call home</h2><div id="logo-black" class="bg-cover fixed" style="background-image: url(images/logo-black.svg)"></div></a>

  <div id="menuToggle">

  <input type="checkbox" />
  <span></span>
    <span></span>
    <span></span>
    <ul id="menu" class="text-center uppercase">
      <a href="index.php"><li>Search properties</li></a>
      <a href="profile.php?id=<?= $sUserId; ?>"><li>Your Profile</li></a>
      <a href="logout.php"><li>Logout</li></a>
    </ul>
  </div>
</nav>
<?php
}
if(!$_SESSION){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $sTitle; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400&display=swap" rel="stylesheet">

    <script src='https://api.mapbox.com/mapbox-gl-js/v1.2.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.2.0/mapbox-gl.css' rel='stylesheet'>

    <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
    <link rel="manifest" href="images/favicon/site.webmanifest">
    <link rel="mask-icon" href="images/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="images/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="images/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
</head>
<body>

<nav role="navigation">
<a href="index.php"><h2 class="color-black slogan fixed">A house to call home</h2><div id="logo-black" class="bg-cover fixed" style="background-image: url(images/logo-black.svg)"></div></a>

  <div id="menuToggle">

  <input type="checkbox" />
  <span></span>
    <span></span>
    <span></span>
    <ul id="menu" class="text-center uppercase">
      <a href="index.php"><li>Search properties</li></a>
      <a href="signup.php"><li>Sign up</li></a>
      <a href="login.php"><li>Login</li></a>
    </ul>
  </div>
</nav>

<?php
}
?>
    