

<?php
require "config.php";
include "0";

session_start();
if (!isset($_SESSION['login_true'])) 
    {
     echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
    exit();
//    header('location: home.php');
    }

//echo $_SESSION['uid'];


    //echo 'Current PHP version: ' . phpversion();

//echo $LS->isLoggedIn();

//var_dump($cookieToken);

/*if($LS->getUser("username") != "")
{

}
else
{
  echo '<p class="login">Please <a href="nesr-login.html">log in</a> to access this page.</p>';
    exit();
}*/

/*if($LS->isLoggedIn()){
  // User logged in
}
else
{
  print_r($LS->cookies());
  echo'I am here';
  echo '<p class="login">Please <a href="nesr-login.html">log in</a> to access this page.</p>';
    exit();
}
*/
/*if ($_SESSION['loggedin'] == true) {

    //echo "Welcome to the member's area, " . $_SESSION['username'] . "!";
} else {
    header('location: login.php');
}*/

/*$alert1 = $LS->isLoggedIn();

if($LS->isLoggedIn() === false){
echo 'alert($alert1)';
//if($LS->isLoggedIn()){
  // User logged in
}else{
  echo 'alert("$alerttrue")';
    header('location: login.php');
}*/

/*if( isset($_POST['newName']) ){
	$_POST['newName'] = $_POST['newName'] == "" ? "Dude" : $_POST['newName'];
	$LS->updateUser(array(
		"name" => $_POST['newName']
	));
}*/

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
    
    #viz, #viz2 {
    float: left;
}

    #text, #country-stat {
    float: left;
}

#pie
{
  margin-left: 20%;
}

#country-stat{
  height: 55px;
  font-size: 35px;
  text-align: center;
}

#ctext{
  padding-bottom: 10px;
  font-style: bold;
}

#ticker{
  margin-left: 40%;
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
  <script src="viz/d3plus/js/d3plus.full.min.js"></script>
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
    <div class="mobile-menu"><a class="mobile-navigation-item w-clearfix" href="home.php"><span class="fontawesome-icon"></span>&nbsp;Visualization</a><a class="mobile-navigation-item w-clearfix" href="Datatables-editor/examples/inline-editing/simple.html"><span class="fontawesome-icon"></span>&nbsp;Management</a><a class="mobile-navigation-item w-clearfix" href="settings.php"><span class="fontawesome-icon"></span>&nbsp;Settings</a><a class="mobile-navigation-item w-clearfix" href="Logout.php"><span class="fontawesome-icon"></span>&nbsp;Logout</a>
  </div>


		<h1 style="margin-left: 10%;">Welcome</h1>
		<p style="margin-left: 10%;">You have been successfully logged in.</p>

    <div id = "ticker">
    <b><div id ="ctext">Number of complete entries: </div></b>
    <div id="country-stat"></div>    
    </div>
    
    
    </br>
    </br>
     </br>
    <div id="viz3" style=" height: 450px; width: 95%;"></div>
    
    <div id = "pie">
    </br>
    </br>
     <div id="viz2" style=" height: 450px; width: 700px;"></div>
    <div id="viz" style=" height: 450px; width: 450px;"></div>
    <!-- <div id="viz2" style=" height: 350px; width: 350px;"></div>
 -->

  
    </div>
  
  <script>

  var data = <?php echo json_encode( $data_pie1, JSON_NUMERIC_CHECK );?>;

  var attributes = [
    {"org_profile_category": "research", "hex": "#a4579e"},
    {"org_profile_category": "submitted survey", "hex": "#50b094"}
  ]

   d3plus.viz()
    .container("#viz")
    .data(data)
    .labels(false)
    .type("pie")
    .id("org_profile_category")
    .size("count")
    .attrs(attributes)
    .color("hex")
    .background("#ededed")
    .legend(
      {"size": 50,
      "text": false}
      )
    .title("Research vs Survey Entries") 
     
    .font({"family":"Palanquin, sans-serif"})
    .draw()

//pie2
    var data2 = <?php echo json_encode( $data_pie2, JSON_NUMERIC_CHECK );?>;

    /* var attributes2 = [
    {"org_profile_status": "publish", "hex": "#eace3f"},
    {"org_profile_status": "dnd", "hex": "#c55542"},
    {"org_profile_status": "edit", "hex": "#a1af00"},
    {"org_profile_status": "submitted", "hex": "#a4579e"}
     ]
    
   d3plus.viz()
    .container("#viz2")
    .data(data2)
    .labels(false)
    .type("pie")
    .id("org_profile_status")
    .size("count")
    .attrs(attributes2)
    .color("hex")
    .background("#ededed")
    .legend(
      {"size": 50,
      "text": false}
      )
    .title("Status of records")
    .font({"family":"Palanquin, sans-serif"})
    .draw() */  

  //Bar graph
  d3plus.viz()
    .container("#viz2")
    .data(data2)
    .type("bar")
    .id("org_profile_status")
    .x("org_profile_status")
    .x({"label": "Status"})
    .y("count")
    .background("#ededed")
    .title("Status of records")
    .font({"family":"Palanquin, sans-serif"})
    //.size("count")
    .draw()

  //line chart

  var data3 = <?php echo json_encode( $data_pie3, JSON_NUMERIC_CHECK );?>;

    var attributes_line = [
    {"value": "Value", "hex": "#CC0000"},
  ]

  // instantiate d3plus
  var visualization = d3plus.viz()
    .container("#viz3")  // container DIV to hold the visualization
    .data(data3)  // data to use with the visualization
    .type("line")       // visualization type
    .id("value")         // key for which our data is unique on
    //.text("name")       // key to use for display text
    //.sort("desc")
    .y("count")         // key to use for y-axis
    .x("cdate")          // key to use for x-axis
    .x({"label": "Date"})
    .attrs(attributes_line)
    .color("hex")
    .background("#ededed")
    .title("Month by Month Entries into the database")
    .font({"family":"Palanquin, sans-serif"})
    .draw()             // finally, draw the visualization!
</script>

<!-- 		<p>This will be the VISUALIZATION Page</p> -->

<!--     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="tempimages/pie.png" alt="pie" height="325" width="325">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <img src="tempimages/bar.png" alt="pie" height="325" width="700"></br></br></br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="tempimages/graph.png" alt="pie" height="325" width="700"> -->
<!-- 		<p>
			<a href="logout.php">Log Out</a>
		</p> -->
<!-- 		<p>
			You registered on this website <strong><?php // echo $LS->joinedSince(); ?></strong> ago. //comment in the center
		</p>
		<p>
			Here is the full data, the database stores on this user :
		</p> -->
<!-- 
    <p>
      <a href="dbmgmt.php">Database Management</a>
    </p>

    <p>
      <a href="change.php">Database Vizualization</a>
    </p> -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js" type="text/javascript"></script>
  <script src="js/webflow.js" type="text/javascript"></script>
  <script type="text/javascript" src="viz/getHomeStat.js"></script>
	</body>
</html>
