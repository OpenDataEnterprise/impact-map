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

  <form id="survey_form" class="form-horizontal" style="border:0px dotted black;" action="/survey/2du/<?php echo $content['surveyId']; ?>" method="post">

    <div class="col-md-12" role="Intro" id="role-intro">
      <div style="text-align:center;font-size:1.1em;margin-top:20px;">
                
        Thank you for participating in the Open Data Impact Map. All edits will be reviewed before they are displayed.
        <br />If you have any questions, email us at map@odenterprise.org. 
      </div>
      <br />
    </div>
  
<br />

    <div class="col-md-12" role="orgInfo-titlebar"  id="role-orgInfo-titlebar">      
      <div class="section-title"><h3>1. Organizational Information</h3></div>
    </div>

    <div class="col-md-12" role="orgInfo"  id="role-orgInfo">
      <!-- Name of organization -->
      <div class="row col-md-12">
        <div class="form-group col-md-12">
          <div class="form-group col-md-10">
            <label for="org_name">Name of organization<small class="required">*</small></label>
            <input type="text" class="form-control" id="org_name" name="org_name" placeholder="" required minlength="2" value="<?php echo $org_profile[0]['org_name'];?>">
            <input type="hidden" class="form-control" id="new_profile_id" name="new_profile_id" value="<?php echo $content['surveyId']?>">
        </div>
        </div>
      </div>

      <!-- Description of organization -->
      <div class="form-group col-md-12">
        <div class="form-group col-md-10">
          <label for="org_description">One sentence description of organization <small class="required">(400 characters or less)*</small></label>
          <textarea type="text" class="form-control " id="org_description" name="org_description" required><?php echo $org_profile[0]['org_description'];?></textarea>
        </div>
      </div>

      <!-- Type of organization -->
      <div class="form-group col-md-12" id="org_type">
          <label for="org_type">Type of organization<small class="required">*</small></label>
        <div class="col-md-10">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default <?php if ("For-profit" == $org_profile[0]['org_type']) {echo "active";} ?>">
                <input type="radio" name="org_type" id="For-profit" value="For-profit" required="True" <?php if ("For-profit" == $org_profile[0]['org_type']) {echo "checked";} ?>> For-profit
            </label>
            <label class="btn btn-default <?php if ("Nonprofit" == $org_profile[0]['org_type']) {echo "active";} ?>">
                <input type="radio" name="org_type" id="Nonprofit" value="Nonprofit" <?php if ("Nonprofit" == $org_profile[0]['org_type']) {echo "checked";} ?>> Nonprofit
            </label>
            <label class="btn btn-default <?php if ("Developer group" == $org_profile[0]['org_type']) {echo "active";} ?>">
                <input type="radio" name="org_type" id="Developer group" value="Developer group" <?php if ("Developer group" == $org_profile[0]['org_type']) {echo "checked";} ?>> Developer group
            </label>
            <label class="btn btn-default <?php if ("Academic institution" == $org_profile[0]['org_type']) {echo "active";} ?>">
                <input type="radio" name="org_type" id="Academic institution" value="Academic institution" <?php if ("Academic institution" == $org_profile[0]['org_type']) {echo "checked";} ?>> Academic institution
            </label>
            <label class="btn btn-default <?php if ("Other" == $org_profile[0]['org_type']) {echo "active";} ?>">
                <input type="radio" name="org_type" id="Other" value="Other" <?php if ("Other" == $org_profile[0]['org_type']) {echo "checked";} ?>> Other
            </label>
          </div>
        </div>
        <?php if ("Other" == $org_profile[0]['org_type']) { ?>
          <div class="col-md-4" id="org_type_other_div"><input type="text" class="form-control" id="org_type_other" name="org_type_other" placeholder="Provide other" required value="<?php echo $org_profile[0]['org_type_other'];?>"></div>
        <?php } ?>
      </div>

      <!-- Website URL -->
      <div class="form-group col-md-12">
        <label for="org_url">Website URL</label>
        <div class="row">      
            <div class="col-md-8">
              <input type="url" class="form-control" id="org_url" name="org_url" placeholder="http://" value="<?php if (null !== $org_profile[0]['org_url']) { echo $org_profile[0]['org_url']; } else { echo null; } ?>">
            </div>
            <div class="col-md-4">
              <input type="checkbox" name="no_org_url" id="no_org_url" value="True" <?php if ($org_profile[0]['no_org_url']) {echo "checked";} ?>> No URL 
            </div>
        </div>
      </div>

      <!-- Location -->  
      <div class="form-group col-md-12">
        <div class="form-group col-md-10 details">

          <label for="org_hq_city_all">Location <small class="required">(Please provide as specific as possible)*</small></label>
          <input type="text" class="form-control" id="org_hq_city_all" name="org_hq_city_all" required value="<?php echo $org_profile[0]['org_hq_city'].", ".$org_profile[0]['org_hq_st_prov'].", ".$org_profile[0]['org_hq_country'];?>">

          <!--label for="org_hq_city">City</label -->
          <input type="hidden" class="form-control" id="org_hq_city" name="org_hq_city" required data-geo="locality" value="<?php echo $org_profile[0]['org_hq_city'];?>">

          <!--label for="org_hq_st_prov">State/Province</label -->
          <input type="hidden" class="form-control" id="org_hq_st_prov" name="org_hq_st_prov" required data-geo="administrative_area_level_1" value="<?php echo $org_profile[0]['org_hq_st_prov'];?>">

          <!--label for="org_hq_country">Country</label -->
          <input type="hidden" class="form-control" id="org_hq_country" name="org_hq_country" required data-geo="country" value="<?php echo $org_profile[0]['org_hq_country'];?>">

          <input type="hidden" class="form-control" id="org_hq_country_locode" name="org_hq_country_locode" data-geo="country_short" value="<?php echo $org_profile[0]['org_hq_country_locode'];?>">

          <!--label for="latitude">lat</label -->
          <input type="hidden" class="form-control" id="latitude" name="latitude" required data-geo="lat" value="<?php echo $org_profile[0]['latitude'];?>">
          <!--label for="longitude">lng</label -->
          <input type="hidden" class="form-control" id="longitude" name="longitude" required data-geo="lng" value="<?php echo $org_profile[0]['longitude'];?>">
        </div>
      </div>
  
      <!-- Industry/category of organization -->
      <div class="form-group col-md-12">
        <label for="industry_id">Sector <small class="required">(select 1)*</small></label>
        <fieldset>
        <div class="col-md-4" id="industry_id_col-1">
          <input type="radio" name="industry_id" class="industry_id" value="Agriculture" <?php if ("Agriculture" == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; Agriculture
          <br /><input type="radio" name="industry_id" class="industry_id" value="Arts, culture and tourism" <?php if ("Arts, culture and tourism" == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; Arts, culture and tourism
          <br /><input id="industry_id_cul" type="radio" name="industry_id" class="industry_id" value="Business, research and consulting" required <?php if ("Business, research and consulting" == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; Business, research and consulting
          <br /><input type="radio" name="industry_id" class="industry_id" value="Consumer" <?php if ("Consumer" == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; Consumer
          <br /><input type="radio" name="industry_id" class="industry_id" value="Education" <?php if ("Education" == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; Education
          <br /><input type="radio" name="industry_id" class="industry_id" value="Energy and climate" <?php if ("Energy and climate" == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; Energy and climate
          <br /><input type="radio" name="industry_id" class="industry_id" value="Finance and insurance" <?php if ("Finance and insurance" == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp;  Finance and insurance
        </div>
        <div class="col-md-4" id="industry_id_col-2">
          <input type="radio" name="industry_id" class="industry_id" value="Governance" <?php if ("Governance" == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; Governance
          <br /><input type="radio" name="industry_id" class="industry_id" value="Health" <?php if ("Health" == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; Health
          <br /><input type="radio" name="industry_id" class="industry_id" value="Housing, construction &amp; real estate" <?php if ("Housing, construction &amp; real estate" == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; Housing, construction &amp; real estate
          <br /><input type="radio" name="industry_id" class="industry_id" value="IT and geospatial" <?php if ("IT and geospatial" == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; IT and geospatial
          <br /><input type="radio" name="industry_id" class="industry_id" value="Media and communications" <?php if ("Media and communications" == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; Media and communications
          <br /><input type="radio" name="industry_id" class="industry_id" value="Transportation and logistics " <?php if ("Transportation and logistics " == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; Transportation and logistics 
          <br /><input type="radio" name="industry_id" class="industry_id" value="Other" <?php if ("Other" == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; Other
              <?php if ("Other" == $org_profile[0]['industry_id']) { ?>
                <input type="text" class="form-control" name="industry_other" placeholder="Describe other" value="<?php echo $org_profile[0]['industry_other'];?>">
              <?php } else { ?>
                <input type="text" class="form-control" style="display:none" name="industry_other" placeholder="Describe other">
              <?php } ?>
        </fieldset>
      </div>

      <!-- Founding year -->    
      <div class="form-group col-md-12">
        <div class="form-group col-md-10">
          <label for="org_year_founded">Founding year<small class="required">*</small></label>
          <input type="text" class="form-control" id="org_year_founded" name="org_year_founded" placeholder="" required value="<?php echo $org_profile[0]['org_year_founded'];?>">
        </div>
      </div>

      <!-- Size -->
      <div class="form-group col-md-12">
        <label for="org_size_id">Size<small class="required">*</small></label>
        <div class="col-md-12">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default <?php if ("1-10" == $org_profile[0]['org_size']) {echo "active";} ?>">
                <input type="radio" name="org_size_id" value="1 to 10" <?php if ("1 to 10" == $org_profile[0]['org_size']) {echo "checked";} ?>> 1-10 employees
            </label>
            <label class="btn btn-default <?php if ("11-50" == $org_profile[0]['org_size']) {echo "active";} ?>">
                <input type="radio" name="org_size_id" value="11 to 50" <?php if ("11 to 50" == $org_profile[0]['org_size']) {echo "checked";} ?>> 11-50 employees
            </label>
            <label class="btn btn-default  <?php if ("51-200" == $org_profile[0]['org_size']) {echo "active";} ?>">
                <input type="radio" name="org_size_id" value="51 to 200" <?php if ("51 to 200" == $org_profile[0]['org_size']) {echo "checked";} ?>> 51-200 employees
            </label>
            <label class="btn btn-default <?php if ("201 to 1000" == $org_profile[0]['org_size']) {echo "active";} ?>">
                <input type="radio" name="org_size_id" value="201-1000" <?php if ("201 to 1000" == $org_profile[0]['org_size']) {echo "checked";} ?>> 201-1000 employees
            </label>
            <label class="btn btn-default <?php if ("1000+" == $org_profile[0]['org_size']) {echo "active";} ?>">
                <input type="radio" name="org_size_id" value="1000+"<?php if ("1000+" == $org_profile[0]['org_size']) {echo "checked";} ?>> 1000+ employees
            </label>
          </div>
        </div>
      </div>

      <!-- What is the greatest type of impact your organization has? -->
      <div class="form-group col-md-12" id="org_greatest_impact">
          <label for="org_greatest_impact">What is the greatest type of impact your organization has?<small class="required">*</small></label>
        <div class="col-xs-9">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default <?php if ("Economic" == $org_profile[0]['org_greatest_impact']) {echo "active";} ?>">
                <input type="radio" name="org_greatest_impact" id="Economic" value="Economic" <?php if ("Economic" == $org_profile[0]['org_greatest_impact']) {echo "checked";} ?>> Economic
            </label>
            <label class="btn btn-default <?php if ("Environmental" == $org_profile[0]['org_greatest_impact']) {echo "active";} ?>">
                <input type="radio" name="org_greatest_impact" id="Environmental" value="Environmental" <?php if ("Environmental" == $org_profile[0]['org_greatest_impact']) {echo "checked";} ?>> Environmental
            </label>
            <label class="btn btn-default <?php if ("Governance" == $org_profile[0]['org_greatest_impact']) {echo "active";} ?>">
                <input type="radio" name="org_greatest_impact" id="Governance" value="Governance" <?php if ("Governance" == $org_profile[0]['org_greatest_impact']) {echo "checked";} ?>> Governance
            </label>
            <label class="btn btn-default <?php if ("Social" == $org_profile[0]['org_greatest_impact']) {echo "active";} ?>">
                <input type="radio" name="org_greatest_impact" id="Social" value="Social"  <?php if ("Social" == $org_profile[0]['org_greatest_impact']) {echo "checked";} ?>> Social
            </label>
            <label class="btn btn-default <?php if ("Other" == $org_profile[0]['org_greatest_impact']) {echo "active";} ?>">
                <input type="radio" name="org_greatest_impact" id="Other" value="Other"  <?php if ("Other" == $org_profile[0]['org_greatest_impact']) {echo "checked";} ?>> Other
            </label>
          </div>
        </div>
          <div class="col-md-10" id="org_greatest_impact_detail_div"><input type="text" class="form-control" id="org_greatest_impact_detail" name="org_greatest_impact_detail" placeholder="Provide other" required value="<?php echo $org_profile[0]['org_greatest_impact_detail'];?>"></div>
      </div>
    </div><!--/OrgInfo-->

<br />

    <div class="col-md-12" role="dataUse-titlebar"  id="role-dataUse-titlebar">
      <div class="section-title"><h3>2. Use of Open Data</h3></div>
    </div>

    <div class="col-md-12" role="dataUse" id="role-dataUse">
      
      <div class="row col-md-12 data-use-row" id="dataUseDataType">
        <label for="data_use_type[]">Types of <u>most relevant</u> open data your organization uses <small class="required">(select all that apply)*</small></label>
        <div class="col-md-4" id="data_type_col-1">
            <input type="checkbox" name="data_use_type[]" class="data_use_type" value="Agriculture" required  <?php if (in_array("Agriculture", $org_data_use1)) {echo "checked";} ?>>&nbsp; Agriculture
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Arts and culture" <?php if (in_array("Arts and culture", $org_data_use1)) {echo "checked";} ?>>&nbsp; Arts and culture
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Business" <?php if (in_array("Business", $org_data_use1)) {echo "checked";} ?>>&nbsp; Business
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Consumer" <?php if (in_array("Consumer", $org_data_use1)) {echo "checked";} ?>>&nbsp; Consumer
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Demographics and social" <?php if (in_array("Demographic and social", $org_data_use1)) {echo "checked";} ?>>&nbsp; Demographic and social
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Economics " <?php if (in_array("Economics", $org_data_use1)) {echo "checked";} ?>>&nbsp; Economics
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Education" <?php if (in_array("Education", $org_data_use1)) {echo "checked";} ?>>&nbsp; Education
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Energy" <?php if (in_array("Energy", $org_data_use1)) {echo "checked";} ?>>&nbsp; Energy
        </div>
        <div class="col-md-4" id="data_type_col-2">
            <input type="checkbox" name="data_use_type[]" class="data_use_type" value="Environment" <?php if (in_array("Environment", $org_data_use1)) {echo "checked";} ?>>&nbsp; Environment
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Finance" <?php if (in_array("Finance", $org_data_use1)) {echo "checked";} ?>>&nbsp; Finance
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Geospatial/mapping" <?php if (in_array("Geospatial", $org_data_use1)) {echo "checked";} ?>>&nbsp; Geospatial
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Government operations" <?php if (in_array("Government operations", $org_data_use1)) {echo "checked";} ?>>&nbsp; Government operations
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Health/healthcare" <?php if (in_array("Health/healthcare", $org_data_use1)) {echo "checked";} ?>>&nbsp; Health/healthcare
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Housing" <?php if (in_array("Housing", $org_data_use1)) {echo "checked";} ?>>&nbsp; Housing
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="International development" <?php if (in_array("International/global development", $org_data_use1)) {echo "checked";} ?>>&nbsp; International development
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Legal" <?php if (in_array("Legal", $org_data_use1)) {echo "checked";} ?>>&nbsp; Legal
        </div>
        <div class="col-md-4" id="data_type_col-3">            
            <input type="checkbox" name="data_use_type[]" class="data_use_type" value="Science and research" <?php if (in_array("Science and research", $org_data_use1)) {echo "checked";} ?>>&nbsp; Science and research
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Public safety" <?php if (in_array("Public safety", $org_data_use1)) {echo "checked";} ?>>&nbsp; Public safety
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Tourism" <?php if (in_array("Tourism", $org_data_use1)) {echo "checked";} ?>>&nbsp; Tourism
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Transportation" <?php if (in_array("Tra", $org_data_use1)) {echo "checked";} ?>>&nbsp; Transportation
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Weather" <?php if (in_array("Weather", $org_data_use1)) {echo "checked";} ?>>&nbsp; Weather
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Other" <?php if (in_array("Other", $org_data_use1) || !isset($org_data_use1)) {echo "checked";} ?>>&nbsp; Other
                  <input type="text" class="form-control" style="" id="data_use_type_other" name="data_use_type_other" placeholder="Provide details" value="<?php if (array_key_exists("data_use_type_other", $org_profile)) {echo $org_profile['data_use_type_other'];} ?>">
        </div>
      </div>
<br />
      <!-- Sources of open data -->

      <?php
        // Deal with data_country_count error
        if (!array_key_exists('data_country_count', $org_profile)) {
          $org_data_use[0]['data_country_count'] = 0;
        }
      ?>
      <div class="form-group col-md-12">
        <label for="data_country_count">Number of countries from which open data is used <small class="required">*</small></label>
        <div class="col-md-12">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default" <?php if ("1" == $org_data_use[0]['data_country_count']) {echo "active";} ?>>
                <input type="radio" name="data_country_count" value="1" <?php if ("1" == $org_data_use[0]['data_country_count']) {echo "checked";} ?>> 1 country
            </label>
            <label class="btn btn-default <?php if ("2 - 5" == $org_data_use[0]['data_country_count']) {echo "active";} ?>">
                <input type="radio" name="data_country_count" value="2 - 5" <?php if ("2 - 5" == $org_data_use[0]['data_country_count']) {echo "checked";} ?>> 2-5 countries
            </label>
            <label class="btn btn-default <?php if ("6 - 10" == $org_data_use[0]['data_country_count']) {echo "active";} ?>">
                <input type="radio" name="data_country_count" value="6 - 10" <?php if ("6 - 10" == $org_data_use[0]['data_country_count']) {echo "checked";} ?>> 6-10 countries
            </label>
            <label class="btn btn-default <?php if ("11 - 20" == $org_data_use[0]['data_country_count']) {echo "active";} ?>">
                <input type="radio" name="data_country_count" value="11 - 20" <?php if ("11 - 20" == $org_data_use[0]['data_country_count']) {echo "checked";} ?>> 11-20 countries
            </label>
            <label class="btn btn-default <?php if ("21 - 50" == $org_data_use[0]['data_country_count']) {echo "active";} ?>">
                <input type="radio" name="data_country_count" value="21 - 50" <?php if ("21 - 50" == $org_data_use[0]['data_country_count']) {echo "checked";} ?>> 21-50 countries
            </label>
            <label class="btn btn-default <?php if ("50+" == $org_data_use[0]['data_country_count']) {echo "active";} ?>">
                <input type="radio" name="data_country_count" value="50+" <?php if ("50+" == $org_data_use[0]['data_country_count']) {echo "checked";} ?>> 50+ countries
            </label>
          </div>
        </div>
      </div>

      <div id="data_use_details">
      </div>

      <div class="row col-md-12">
        <label class="row col-md-10">
          How does your organization use open data?<small class="required">*</small> 
        </label>

        <div class="form-group col-md-12">
          <div class="col-md-6" id="use_open_data_col-1">
             <div>
              <input type="checkbox" class="use_open_data" name="use_advocacy" id="use_advocacy" value="True" <?php if ("1" == $org_profile[0]['advocacy']) {echo "checked";} ?>> advocacy
              <textarea class="form-control" style="" id="use_advocacy_desc" name="use_advocacy_desc" placeholder="Provide details"><?php if (array_key_exists("advocacy_desc", $org_profile[0])) {echo $org_profile[0]['advocacy_desc'];} ?></textarea>
            </div>
            <div>
              <input type="checkbox" class="use_open_data" name="use_prod_srvc" id="use_prod_srvc" value="True" <?php if ("1" == $org_profile[0]['prod_srvc']) {echo "checked";} ?>> develop new products or services
              <textarea class="form-control" style="" id="use_prod_srvc_desc" name="use_prod_srvc_desc" placeholder="Provide details"><?php if (array_key_exists("prod_srvc_desc", $org_profile[0])) {echo $org_profile[0]['prod_srvc_desc'];} ?></textarea>
            </div>
            <div>
              <input type="checkbox" class="use_open_data" name="use_org_opt" id="use_org_opt" value="True" <?php if ("1" == $org_profile[0]['org_opt']) {echo "checked";} ?>> organizational optimization <i>(e.g. benchmarking, market analysis, improving efficiency, enhancing existing products and services)</i>
              <textarea class="form-control" style="" id="use_org_opt_desc" name="use_org_opt_desc" placeholder="Provide details"><?php if (array_key_exists("org_opt_desc", $org_profile[0])) {echo $org_profile[0]['org_opt_desc'];} ?></textarea>
            </div>
          </div>

          <div class="col-md-6" id="use_open_data_col-2">
            <div>
              <input type="checkbox" class="use_open_data" name="use_research" id="use_research" value="True" <?php if ("1" == $org_profile[0]['research']) {echo "checked";} ?>> research
              <textarea class="form-control" style="" id="use_research_desc" name="use_research_desc" placeholder="Provide details"><?php if (array_key_exists("research_desc", $org_profile[0])) {echo $org_profile[0]['research_desc'];} ?></textarea>
            </div>
            <div>
              <input type="checkbox" class="use_open_data" name="use_other" id="use_other" value="True" <?php if ("1" == $org_profile[0]['use_other']) {echo "checked";} ?>> other
              <textarea class="form-control" style="" id="use_other_desc" name="use_other_desc" placeholder="Provide details"><?php if (array_key_exists("use_other", $org_profile[0])) {echo $org_profile[0]['use_other_desc'];} ?></textarea>
            </div>
          </div>
        </div>
      </div>

      <!-- Additional description --> 
      <div class="row col-md-12">
        <label class="row col-md-10">
          Additional information <small class="optional">(optional, 400 characters or less)</small>
        </label>

        <div class="row col-md-10">
          <textarea type="text" class="form-control" id="org_additional" name="org_additional" placeholder="E.g. How could the open data your organization uses be improved? Which datasets are most valuable to your organization? What other types of data does your organization use in addition to open government data?"><?php echo $org_profile[0]['org_additional'];?></textarea>
        </div>
      </div>
      <br />
    </div>

    <br />
 
    <div class="col-md-12" role="contact-titlebar"  id="role-contact-titlebar">
      <div class="section-title"><h3>3. Contact Information <small>(This information will not be made public)</small></h3></div>
    </div>

    <div class="col-md-12" role="contact" id="role-contact">

      <div class="form-group col-md-12">
        <div class="col-md-5">
          <div for="survey_contact_first">First name<small class="required">*</small></div>
          <input type="text" class="form-control" id="survey_contact_first" name="survey_contact_first" required>
        </div>

        <div class="col-md-5">
          <div for="survey_contact_last">Last name<small class="required">*</small></div>
          <input type="text" class="form-control" id="survey_contact_last" name="survey_contact_last" required>
        </div>

        <div class="col-md-10">
          <div for="survey_contact_title">Title <i>(optional)</i></div>
          <input type="text" class="form-control" id="survey_contact_title" name="survey_contact_title">

          <div for="survey_contact_email">Email<small class="required">*</small></div>
          <input type="email" class="form-control" id="survey_contact_email" name="survey_contact_email" required>

          <div for="survey_contact_email">Phone <i>(optional)</i></div>
          <input type="text" class="form-control" id="survey_contact_phone" name="survey_contact_phone">

          <input type="hidden" class="form-control" id="org_profile_year" name="org_profile_year" value=" <?php echo $org_profile[0]['org_profile_year']; ?>">
          <input type="hidden" class="form-control" id="org_profile_status" name="org_profile_status" value="edit">
          <input type="hidden" class="form-control" id="org_profile_src" name="org_profile_src" value="survey-edit">
          <input type="hidden" class="form-control" id="profile_id" name="old_profile_id" value="<?php echo $org_profile[0]['profile_id']?>">
          <input type="hidden" class="form-control" id="m_read" name="m_read" value="<?php echo $org_profile[0]['machine_read']?>">
          <input type="hidden" class="form-control" id="data_country_count" name="data_country_count" value="<?php echo $org_profile[0]['data_country_count']?>">
          <input type="hidden" class="form-control" id="org_profile_category" name="org_profile_category" value="<?php echo $org_profile[0]['org_profile_category']?>">
        </div>
      </div>
    </div><!-- /closes role contact -->
      
      <br />

    <div class="col-md-12" role="submit-note" id="role-submit-note">
      <div style="text-align:center;font-size:16px;margin-top:20px;">
        <b>Information collected will be reviewed before it is displayed on the Map and made available as open data.</b>
      </div>
      <br />
    </div>
    <div class="col-md-12" style="text-align:center;">    
      <button class="btn btn-primary" style="padding:1em 2em 1em 2em; width:200px; background-color: rgb(53, 162, 227);" id="btnSubmit" type="submit" name="submit" value="submit">SUBMIT</button>
    </div>

      
    </div>

</form>

</div> 
<!-- I think I am missing a closing </div> gut things are working. -->
<!-- end container - where is the tag? -->

<?php include __DIR__.'/'.'tp_pt_footer.php'; ?>

