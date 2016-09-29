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

<!-- exploration -->
<style>
	.controlsec {
		border:0px solid #eee; 
		margin: 12px 0px 0px 0px; 
	}

  .myeditable {
    height: 200px;
    width: 150%;
  }

  .myeditableshow {
  }

  h3 {
    border-bottom: 1px dotted #ddd;
    margin: 24px 0px 16px 0px;
  }

 /* Important to get editable to be full width (see: https://github.com/vitalets/x-editable/issues/361#issuecomment-74871125) */
  .editable-container.editable-inline,
  .editable-container.editable-inline .control-group.form-group,
  .editable-container.editable-inline .control-group.form-group .editable-input,
  .editable-container.editable-inline .control-group.form-group .editable-input textarea,
  .editable-container.editable-inline .control-group.form-group .editable-input select,
  .editable-container.editable-inline .control-group.form-group .editable-input input:not([type=radio]):not([type=checkbox]):not([type=submit])
{
    width: 85%!important;
}

body {
  font-size: 11pt;
}

</style>

<!-- Main Content Section -->
<div class="container lg-font col-md-12" style="border:0px solid black;">

 <form class="form-horizontal"><!-- using form tag for moment to preserve left side alignment -->

    <div class="row col-md-12 controlsec" role="orgInfo">
     	<div class="row col-md-12">
     			<h3>Organization information</h3>
     	</div>

        <div class="form-group col-md-12">
          <div class="form-group col-md-9">

            <?php echo $org_profile['org_name']; ?>
            <br />
            <?php echo $org_profile['org_type']; ?>, 
            <?php 
              $industries = array("bus" => "Business &amp; legal services", "cul" => "Culture/Leisure", "dat" => "Data/Technology", "edu" => "Education", "ngy" => "Energy", "env" => "Environment &amp; weather", "fin" => "Finance &amp; investment", "agr" => "Food &amp; agriculture", "geo" => "Geospatial/Mapping", "gov" => "Governance", "hlt" => "Healthcare", "est" => "Housing/Real estate", "hum" => "Human rights", "ins" => "Insurance", "lif" => "Lifestyle &amp; consumer", "med" => "Media &amp; communications", "man" => "Mining/Manufacturing", "rsh" => "Research &amp; consulting", "sci" => "Scientific research", "tel" => "Telecommunication/ISPs", "trm" => "Tourism", "trd" => "Trade &amp; commodities", "trn" => "Transportation", "otr" => "Other");
              if ( array_key_exists('industry_id', $org_profile) && array_key_exists($org_profile['industry_id'], $industries) ) {
                echo $industries[$org_profile['industry_id']];
                if ( $org_profile['industry_id'] == 'otr' ) {
                  echo $org_profile['industry_other'];
                }
              }
            ?>
            <br />
            <a href="<?php echo $org_profile['org_url']; ?>"><?php echo $org_profile['org_url']; ?></a>
            <br />
            <?php echo $org_profile['org_size_id']; ?> employees
            <br />
            Founded: <?php echo $org_profile['org_year_founded']; ?>
            
            <br />
            <?php echo $org_profile['org_hq_city'].", ".$org_profile['org_hq_st_prov'].", ".$org_profile['org_hq_country']; ?>
            <br />
            <br />
            <p class="muted">Description</p>
            <?php echo strip_tags($org_profile['org_description']); ?>
            <br />
            
        </div>
        </div>

      <div class="row col-md-12" role="dataTypes">
        <div class="row col-md-12">
          <h3>Use of open government data</h3>
        </div>

            <div class=" col-md-12">
              <div class="row">
                <p class="muted">Data uses and sources</p>
                <label class="col-md-4">Data type</label>
                <label class="col-md-4">Country code</label>
                <label class="col-md-4">Government level </label>
              </div>
              <div class="row">
                <?php 
                  foreach($org_data_use as $data_use) {
                    echo '<div class="col-md-4">'.$data_use['data_type'];
                    if ($data_use['data_type'] == "Other") {
                      echo ': '.$data_use['data_type_other'];
                    }
                    echo "</div>";
                    echo '<div class="col-md-4">'.$data_use['data_src_country_locode']."</div>";
                    echo '<div class="col-md-4">'.$data_use['data_src_gov_level']."</div>";
                  }
                ?>
              </div>
            </div>
            <br />
          
            <p class="muted">Purpose open data serves in organization</p>

            <div class="col-md-3">Develop new products or services
              <?php if ($org_profile['use_prod_srvc']) { echo "<br />Yes, ".$org_profile["use_prod_srvc_desc"] ;} else { echo "<br />No<br />"; } ?>
            </div>

            <div class="col-md-3">Organizational optimization
              <?php if ($org_profile['use_org_opt']) { echo "<br />Yes, ".$org_profile["use_org_opt_desc"] ;} else { echo "<br />No<br />"; } ?>
            </div>

             <div class="col-md-3">Research
              <?php if ($org_profile['use_research']) { echo "<br />Yes, ".$org_profile["use_research_desc"] ;} else { echo "<br />No<br />"; } ?>
            </div>

            <div class="col-md-3">Other
              <?php if ($org_profile['use_other']) { echo "<br />Yes, ".$org_profile["use_other_desc"] ;} else { echo "<br />No<br />"; } ?>
            </div>

            <br />
            <br />
            <br />
            <p class="muted">Most important way in which organization has a positive impact</p>
            <?php echo strip_tags($org_profile['org_greatest_impact']); ?>
            <br />

      </div><!-- /dataTypes -->



      </div><!--/OrgInfo-->



</form>

</div>

<!-- I think I am missing a closing </div> gut things are working.
<!--/end container - where is the tag?-->

<?php include __DIR__.'/'.'tp_pt_footer.php'; ?>