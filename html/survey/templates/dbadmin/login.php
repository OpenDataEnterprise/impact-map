<?php
require "config.php";
if(isset($_POST['action_login'])){
	$identification = $_POST['login'];
	$password = $_POST['password'];
	if($identification == "" || $password == ""){
		$msg = array("Error!", "Wrong Username / Password!");
	}else{
		$login = $LS->login($identification, $password, isset($_POST['remember_me']), false);
    
    if (is_numeric($login)) 
    {
    echo 'login value is ' .$login;
    session_start();
    $_SESSION['login_true'] = $login;
    print_r($_SESSION); 
    header("Location: home.php"); /* Redirect browser */
    exit();
//    header('location: home.php');
    }

    	if($login === false){
			$msg = array("Error!", "Wrong Username / Password!");
		}else if(is_array($login) && $login['status'] == "blocked"){
			$msg = array("Error!", "Too many login attempts. You can attempt login after ". $login['minutes'] ." minutes (". $login['seconds'] ." seconds)");
		}
}
}
?>
<html>
  <head>
  <meta charset="utf-8">
  <title>Database Admin Tool - Login</title>
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
    <div class="content">
      <h1 style = "text-align: center; margin-top: 3%">Database Admin Tool</h1>
      </br>
      <?php
      if(isset($msg)){
        echo "<h2 style = 'text-align: center; color:red;'>{$msg[0]}</h2><p style = 'text-align: center;color:red;'>{$msg[1]}</p>";
      }
      ?>
      <form action="login.php" method="POST" style="margin:0px auto;display:table;">
        <label>
          <p>Username / E-Mail</p>
          <input name="login" type="text"/>
        </label><br/>
        <label>
          <p>Password</p>
          <input name="password" type="password"/>
        </label><br/>
        <label>
<!--           <p>
            <input type="checkbox" name="remember_me"/> Remember Me
          </p> -->
        </label>
        <div clear></div>
        <button style="width:150px;color:white" name="action_login" class="button">Log In</button>
        </br>
            <!-- <p>
        <p>Forgot Your Password ?</p>
        <a style="width:150px; color:white;text-decoration: none;" class="button" href="reset.php">Reset Password</a>
      </p> -->
      </form>
      <style>
        input[type=text], input[type=password]{
          width: 230px;
        }
      </style> 
        <p style = "text-align: center;">Don't have an account ?</p>
        <a style="width:150px; color:white" class="button" href="register.php">Register</a>
      

    </div>
  </body>
</html>