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
      <div style="text-align:center;font-size:1.1em;margin-top:20px;">
        &nbsp;
      </div>
    </div>
     
    <div class="col-md-12" role="eligibility" id="role-eligibility">
      <div class="row col-md-12">
        <h4>OOPS!</h4>
      </div>
      <div>
        <b><?php echo $content['error_msg_title']; ?></b>
        <br /><br />
          <?php echo $content['error_msg_details']; ?>
      </div>
    </div>

</div> 
<!-- I think I am missing a closing </div> gut things are working. -->
<!-- end container - where is the tag? -->

<?php include __DIR__.'/'.'tp_pt_footer.php'; ?>