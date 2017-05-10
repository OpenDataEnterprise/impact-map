<?php
require "config.php";
session_start();
if (!isset($_SESSION['login_true'])) 
    {
     echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
    exit();
//    header('location: home.php');
    }
?>
<!-- <!DOCTYPE html> -->
<html>
  <head>
    <title>Change Password</title>
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
#changepass{
  text-align: center;
  margin-top: 20px;
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

    <div class="navigation">
    <div class="navigation-container w-clearfix w-hidden-medium w-hidden-small w-hidden-tiny">
<a class="navigation-link" href="home.php"><span class="fontawesome-icon"></span>&nbsp;Visualization</a><a class="navigation-link" href="Datatables-editor/examples/inline-editing/simple.html"><span class="fontawesome-icon"></span>&nbsp;Management</a><a class="navigation-link secondary-navigation-link" href="logout.php"><span class="fontawesome-icon"></span>&nbsp;Logout</a><a class="navigation-link secondary-navigation-link" href="settings.php"><span class="fontawesome-icon"></span>&nbsp;Settings</a>

    </div>
    <div class="mobile-navigation-container w-clearfix w-hidden-main"><a class="mobile-menu-button" data-ix="open-mobile-menu" href="#"><span class="fontawesome-icon"></span> Menu</a><a class="close-menu-button" data-ix="close-mobile-menu" href="#"><span class="fontawesome-icon"></span> Close</a>
      <div class="mobile-navigation-title">Open Data Impact Map</div>
    </div>
  </div>
  <div class="navigation-space-fix" id="top"></div>

<div id = "changepass">
  
<h2>Change Password</h2>
</br>
    <?php
    if(isset($_POST['change_password'])){
      if(isset($_POST['current_password']) && $_POST['current_password'] != "" && isset($_POST['new_password']) && $_POST['new_password'] != "" && isset($_POST['retype_password']) && $_POST['retype_password'] != "" && isset($_POST['current_password']) && $_POST['current_password'] != ""){
          
        $curpass = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $retype_password = $_POST['retype_password'];
          
        if($new_password != $retype_password){
          echo "<p><h2>Passwords Doesn't match</h2><p>The passwords you entered didn't match. Try again.</p></p>";
        }
        else if($LS->login($LS->getUser("username"), $curpass, false, false) == false){
          echo "<h2>Current Password Wrong!</h2><p>The password you entered for your account is wrong.</p>";
        }
        else{
          $change_password = $LS->changePassword($new_password);
          if($change_password === true){
            echo "<h2>Password Changed Successfully</h2>";
          }
        }
      }else{
        echo "<p><h2>Password Fields was blank</h2><p>Form fields were left blank</p></p>";
      }
    }
    ?>
    <form action="<?php echo $LS->curPageURL();?>" method='POST'>
      <label>
        <p>Current Password</p>
        <input type='password' name='current_password' />
      </label>
      <label>
        <p>New Password</p>
        <input type='password' name='new_password' />
      </label>
      <label>
        <p>Retype New Password</p>
        <input type='password' name='retype_password' />
      </label>
      <button style="text-align: center;width:150px; color:white; margin-top: 20px" class = "button" name='change_password' type='submit'>Submit</button>
    </form>
  </div>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js" type="text/javascript"></script>
  <script src="js/webflow.js" type="text/javascript"></script>
  </body>
</html>
