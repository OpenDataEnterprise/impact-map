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
      <div class="section-title"><h3>SUBMISSION RECEIVED</h3></div>
    </div>
 
    <div class="col-md-12" role="orgInfo"  id="role-orgInfo" style="font-size:14pt;height:330px; margin-top">
    
    <div class="row col-md-12">
        <div>
          Thank you contributing to the Open Data Impact Map. All submissions will be reviewed before public display.  
        </div>

        <br /><br />
        Please help us spread the word!<br /><br />
        
          <div class="w-row share-row">
            <div class="w-col w-col-3 w-col-small-3 w-col-tiny-3">
              <a class="w-inline-block share-icon" href="https://twitter.com/home?status=Check%20out%20the%20%23OpenData%20Impact%20Map,%20a%20global%20view%20of%20open%20data%20use%20cases%20at%20http://<?php echo $content['HTTP_HOST']; ?>/map.html%20%23ODImpactMap%20%40odenterprise" target="_blank"><img src="http://<?php echo $content['HTTP_HOST']; ?>/survey/img/Share-twitter.png">
              </a>
            </div>
            <div class="w-col w-col-3 w-col-small-3 w-col-tiny-3">
              <a class="w-inline-block share-icon" href="https://www.facebook.com/sharer/sharer.php?u=http://<?php echo $content['HTTP_HOST']; ?>/map.html" target="_blank"><img src="http://<?php echo $content['HTTP_HOST']; ?>/survey/img/Share-facebook.png">
              </a>
            </div>
            <div class="w-col w-col-3 w-col-small-3 w-col-tiny-3">
              <a class="w-inline-block share-icon" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=http://<?php echo $content['HTTP_HOST']; ?>/map.html&amp;title=&amp;summary=Check%20out%20the%20Open%20Data%20Impact%20Map,%20a%20global%20view%20of%20open%20data%20use%20cases%20at%0Ahttp://<?php echo $content['HTTP_HOST']; ?>/map.html" target="_blank"><img src="http://<?php echo $content['HTTP_HOST']; ?>/survey/img/Share-linkedin.png">
              </a>
            </div>
            <div class="w-col w-col-3 w-col-small-3 w-col-tiny-3">
              <a class="w-inline-block share-icon" href="mailto:?&amp;subject=Open Data Impact Map&amp;body=Check%20out%20the%20Open%20Data%20Impact%20Map,%20a%20global%20view%20of%20open%20data%20use%20cases%20at%20http://<?php echo $content['HTTP_HOST']; ?>/map.html" target="_blank"><img src="http://<?php echo $content['HTTP_HOST']; ?>/survey/img/Share-email.png">
              </a>
            </div>
          </div>
          <br /><br />

        If you have any questions, please email us at map@odenterprise.org.
        <br />
    </div>

  </div><!--/Intro-->

</div>

<!-- I think I am missing a closing </div> gut things are working.
<!--/end container - where is the tag?-->

<?php include __DIR__.'/'.'tp_pt_footer.php'; ?>