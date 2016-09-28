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

<!-- Main Content Section -->
<div class="container lg-font col-md-12" style="border:0px solid black;">
 
    <div class="col-md-12" role="Intro" id="role-intro">
      <div style="text-align:center;font-size:2.1em;margin-top:20px;">
        To edit <?php echo $org_name; ?>
      </div>
    </div>
     
    <div class="col-md-12" role="eligibility" id="role-eligibility">
      <div class="row col-md-12">
        <h4>Please provide:</h4>
          <ul>
            <li>Your contact details and organizational affiliation (as proof that you are qualified to edit the submission)</li>
            <li>Responses in plain, functional language (avoid marketing and promotional language)</li>
          </ul>
          <div style="text-align:center;">
            <i>All edits will be reviewed before public display on the Open Data Impact Map.</i>
          </div>
          <br />
      </div>
      <div style="text-align:center;">
        <b>Click here to edit:</b>
        <br />
          <a href="http://<?php echo $content['HTTP_HOST']; ?>/map/survey/edit/<?php echo $content['surveyId']; ?>/form">http://<?php echo $content['HTTP_HOST']; ?>/map/survey/edit/<?php echo $content['surveyId']; ?>/form</a>
      </div>
    </div>

</div> 
<!-- I think I am missing a closing </div> gut things are working. -->
<!-- end container - where is the tag? -->

<?php include __DIR__.'/'.'tp_pt_footer.php'; ?>