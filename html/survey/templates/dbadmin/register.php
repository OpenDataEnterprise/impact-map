<?php
include "config.php";
?>
<!DOCTYPE html>
<html>
  <head>
  <meta charset="utf-8">
  <title>Register</title>
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
      <h2 style = "text-align: center;">Register</h2></br></br>
      <form action="register.php" method="POST">
        <label style = "text-align: center;">
          <input name="username" placeholder="Username" />
        </label> </p>
        <label style = "text-align: center;">
          <input name="email" placeholder="E-Mail" /> 
        </label></p>
        <label style = "text-align: center;">
          <input name="pass" type="password" placeholder="Password" />
        </label></p>
        <label style = "text-align: center;">
          <input name="retyped_password" type="password" placeholder="Retype Password" />
        </label></p>
        <label style = "text-align: center;">
          <input name="name" placeholder="Name" />
        </label></p>
        <label style = "text-align: center;color:white;text-decoration: none;" >
          <button name="submit" class="button">Register</button>
        </label></p>
      </form>
      <?php
      if( isset($_POST['submit']) ){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['pass'];
        $retyped_password = $_POST['retyped_password'];
        $name = $_POST['name'];
        if( $username == "" || $email == "" || $password == '' || $retyped_password == '' || $name == '' ){
            echo "<h2>Fields Left Blank</h2>", "<p>Some Fields were left blank. Please fill up all fields.</p>";
        }elseif( !$LS->validEmail($email) ){
            echo "<h2>E-Mail Is Not Valid</h2>", "<p>The E-Mail you gave is not valid</p>";
        }elseif( !ctype_alnum($username) ){
            echo "<h2>Invalid Username</h2>", "<p>The Username is not valid. Only ALPHANUMERIC characters are allowed and shouldn't exceed 10 characters.</p>";
        }elseif($password != $retyped_password){
            echo "<h2>Passwords Don't Match</h2>", "<p>The Passwords you entered didn't match</p>";
        }else{
          $createAccount = $LS->register($username, $password,
            array(
              "email" => $email,
              "name" => $name,
              //"created" => date("Y-m-d H:i:s") // Just for testing
            )
          );
          if($createAccount === "exists"){
            echo "<label>User Exists.</label>";
          }elseif($createAccount === true){
            echo "<label>Success. Created account. <a href='login.php'>Log In</a></label>";
          }
        }
      }
      ?>
      <style>
        label{
          display: block;
          margin-bottom: 5px;
        }
      </style>
    </div>
  </body>
</html>
