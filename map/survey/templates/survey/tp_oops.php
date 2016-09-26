<?php 
// I18N support information here
// $language = "fr_FR";
$language = $content['language'];
putenv("LANG=" . $language); 
setlocale(LC_ALL, $language);
 
// Set the text domain as "messages"
$domain = "messages";
bindtextdomain($domain, "Locale"); 
bind_textdomain_codeset($domain, 'UTF-8');
 
textdomain($domain);
?>
<?php include __DIR__.'/'.'tp_pt_header.php'; ?>

  <!-- Start main content section -->

        <div class="col-md-9" role="main">
<!--
        <h2><?php echo $content['title']; ?><br /><small>helper text</small></h2>
-->
 </div> <!--/end main -->



<!-- Main Content Section -->
<div class="container lg-font col-md-12" style="border:0px solid black;">

    <div class="col-md-12" role="orgInfo-titlebar"  id="role-orgInfo-titlebar" style="margin-top: 40px;">
      <div class="section-title"><h3>Oops!</h3></div>
    </div>
 
    <div class="col-md-12" role="orgInfo"  id="role-orgInfo" style="font-size:14pt;height:400px; margin-top">
    
    <div class="row col-md-12">
        <div>
          Our bad! Please <a href="http://<?php echo $content['HTTP_HOST']; ?>/map/survey/start/">Try again</a>
        </div>
    </div>

  </div><!--/Intro-->

</div>

<!-- I think I am missing a closing </div> gut things are working.
<!--/end container - where is the tag?-->

<?php include __DIR__.'/'.'tp_pt_footer.php'; ?>