<?php
require "config.php";
/*if( isset($_POST['newName']) ){
	$_POST['newName'] = $_POST['newName'] == "" ? "Dude" : $_POST['newName'];
	$LS->updateUser(array(
		"name" => $_POST['newName']
	));
}*/
session_start();
if (!isset($_SESSION['login_true'])) 
    {
     echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
    exit();
//    header('location: home.php');
    }
?>
<html>
	<!-- <head></head> -->
	<head>
  <meta charset="utf-8">
  <title>Database Admin Tool</title>
  <meta content="Open Data Impact Map" property="og:title">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <meta content="Webflow" name="generator">
  <link href="css/normalize.css" rel="stylesheet" type="text/css">
  <link href="css/webflow.css" rel="stylesheet" type="text/css">
  <link href="css/open-data-impact-map.webflow.css" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js"></script>
  <script type="text/javascript">
    WebFont.load({
      google: {
        families: ["Palanquin:100,200,300,regular,500,600,700"]
      }
    });
  </script>
 <script src="js/modernizr.js" type="text/javascript"></script>
  <link href="images/impactfaviconsmall.png" rel="shortcut icon" type="image/x-icon">
  <link href="impactfaviconlarge.png" rel="apple-touch-icon">
  <style>
    li { display: list-item; }
    #settings {
      text-align: center;
    }
  </style>
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-85257177-1', 'auto');
    ga('send', 'pageview');
  </script>
</head>
	<body>

<!--   <div class="navigation">
    <div class="navigation-container w-clearfix w-hidden-medium w-hidden-small w-hidden-tiny"><a class="navigation-link" href="index.html"><span class="fontawesome-icon"></span>&nbsp;Home</a><a class="navigation-link" href="/map.html"><span class="fontawesome-icon"></span>&nbsp;MAP | DATA</a><a class="navigation-link" href="regions.html"><span class="fontawesome-icon"></span>&nbsp;Findings by Region</a><a class="navigation-link" href="sectors.html"><span class="fontawesome-icon"></span>&nbsp;Findings by SEctor</a><a class="last-left navigation-link" href="/usecases.html"><span class="fontawesome-icon"></span>&nbsp;Use Cases</a><a class="navigation-link secondary-navigation-link" href="contact.html"><span class="fontawesome-icon"></span>&nbsp;Contact</a>
    </div>
    <div class="mobile-navigation-container w-clearfix w-hidden-main"><a class="mobile-menu-button" data-ix="open-mobile-menu" href="#"><span class="fontawesome-icon"></span> Menu</a><a class="close-menu-button" data-ix="close-mobile-menu" href="#"><span class="fontawesome-icon"></span> Close</a>
      <div class="mobile-navigation-title">Open Data Impact Map</div>
    </div>
  </div>
  <div class="navigation-space-fix" id="top"></div> -->
<!--   <div class="mobile-menu"><a class="mobile-navigation-item w-clearfix" href="index.html"><span class="fontawesome-icon"></span>&nbsp;HOME</a><a class="mobile-navigation-item w-clearfix" href="/map.html"><span class="fontawesome-icon"></span>&nbsp;MAP</a><a class="mobile-navigation-item w-clearfix" href="regions.html"><span class="fontawesome-icon"></span>&nbsp;FINDINGS BY REGION</a><a class="mobile-navigation-item w-clearfix" href="sectors.html"><span class="fontawesome-icon"></span>&nbsp;FINDINGS BY SECTOR</a><a class="mobile-navigation-item" href="/usecases.html"><span class="fontawesome-icon"></span>&nbsp;USE CASES</a><a class="mobile-navigation-item secondary w-clearfix" href="contact.html"><span class="fontawesome-icon"></span>&nbsp;CONTACT</a>
  </div> -->
  <div class="navigation">
    <div class="navigation-container w-clearfix w-hidden-medium w-hidden-small w-hidden-tiny">
<a class="navigation-link" href="home.php"><span class="fontawesome-icon"></span>&nbsp;Visualization</a><a class="navigation-link" href="Datatables-editor/examples/inline-editing/simple.html"><span class="fontawesome-icon"></span>&nbsp;Management</a><a class="navigation-link secondary-navigation-link" href="logout.php"><span class="fontawesome-icon"></span>&nbsp;Logout</a><a class="navigation-link secondary-navigation-link" href="settings.php"><span class="fontawesome-icon"></span>&nbsp;Settings</a>

    </div>
    <div class="mobile-navigation-container w-clearfix w-hidden-main"><a class="mobile-menu-button" data-ix="open-mobile-menu" href="#"><span class="fontawesome-icon"></span> Menu</a><a class="close-menu-button" data-ix="close-mobile-menu" href="#"><span class="fontawesome-icon"></span> Close</a>
      <div class="mobile-navigation-title">Open Data Impact Map</div>
    </div>
  </div>
  <div class="navigation-space-fix" id="top"></div>
    <div class="mobile-menu"><a class="mobile-navigation-item w-clearfix" href="home.php"><span class="fontawesome-icon"></span>&nbsp;Visualization</a><a class="mobile-navigation-item w-clearfix" href="Datatables-editor/examples/inline-editing/simple.html"><span class="fontawesome-icon"></span>&nbsp;Management</a><a class="mobile-navigation-item w-clearfix" href="settings.php"><span class="fontawesome-icon"></span>&nbsp;Settings</a><a class="mobile-navigation-item w-clearfix" href="Logout.php"><span class="fontawesome-icon"></span>&nbsp;Logout</a>
  </div>

<!-- 		<h1>Welcome</h1>
		<p>You have been successfully logged in.</p> -->
<!-- 		<p>
			<a href="logout.php">Log Out</a>
		</p> -->
<!-- 		<p>

		</p>
		<p>
			Here is the full data, the database stores on this user :
		</p> -->
    <div id = "settings">
		<pre><?php
			$details = $LS->getUser();
			print_r($details);
			?></pre>
<!-- 		<p>
			Change the name of your account :
		</p>
		<form action="home.php" method="POST">  
			<input name="newName" placeholder="New name" />
			<button>Change Name</button>
		</form>

 -->    <p>
     </br>
<!--       <a href="change.php">Change Password</a> -->
      <a style="width:150px; color:white" class="button" href="change.php">Change Password</a>
    </p>
    </br>
          <p>
<!--         <p>Don't have an account ?</p> -->
        <a style="width:150px; color:white" class="button" href="register.php">Register User</a>
      </p>
<!-- 
    <p>
      <a href="dbmgmt.php">Database Management</a>
    </p>

    <p>
      <a href="change.php">Database Vizualization</a>
    </p> -->
</div>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js" type="text/javascript"></script>
  <script src="js/webflow.js" type="text/javascript"></script>

	</body>
</html>
