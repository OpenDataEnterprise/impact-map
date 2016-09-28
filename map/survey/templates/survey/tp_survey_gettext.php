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

 <form id="survey_form" class="form-horizontal" style="border:0px dotted black;" action="/map/survey/2du/<?php echo $content['object_id']; ?>" method="post">

    <div class="col-md-12" role="Intro" id="role-intro">
      <div style="text-align:center;font-size:1.1em;margin-top:20px;">
        <div class="col-md-6 small">&nbsp;</div><div class="col-md-6 pull-right small" style="font-size:14px;">
        <a href="/map/survey/start">English</a>&nbsp;&nbsp;
          <?php
            $langs = array('es_MX' => 'Español', 'fr_FR' => 'Français', 'de_DE' => 'Deutsch', 'ko_KR' => '한국어 조선말', 'ru_RU' => 'русский', 'pt_BR' => 'Português');
            foreach ($langs as $key => $value) {
              if ($language == $key) {
                echo "$value &nbsp;&nbsp;";
              } else {
                echo "<a href=\"/map/survey/start/$key\">$value</a> &nbsp;&nbsp; ";
              }
            }
          ?>         
        </div>
        
        <?php echo gettext("THANKS_PARTICIPATING") ?>
        <?php echo _("YOUR_CONTRIBUTION") ?>
        <?php echo _("INFO_COLLECTED") ?>
      </div>
      <br />
    </div>
     
    <div class="col-md-12" role="eligibility" id="role-eligibility">
      <div class="row col-md-12">
        <h4><?php echo _("ELIGIBILITY") ?></h4>
      </div>
      <div>
        <b><?php echo _("MAP_INCLUDES_ORGS") ?></b>
          <ul>
              <li><?php echo _("ARE_COMPANIES") ?></li>
              <li><?php echo _("USE_OPEN_GOVERNMENT_DATA") ?></li>
            </ul>
        <?php echo _("WE_DEFINE_OPEN") ?> 
      </div>
    </div>

<br />

    <div class="col-md-12" role="orgInfo-titlebar"  id="role-orgInfo-titlebar">
      <div class="section-title"><h3> <?php echo _("ORG_INFO") ?></h3></div>
    </div>

    <div class="col-md-12" role="orgInfo"  id="role-orgInfo">
      <!-- Name of organization -->
      <div class="row col-md-12">
        <div class="form-group col-md-12">
          <div class="form-group col-md-10">
            <label for="org_name"> <?php echo _("ORG_NAME") ?><small class="required">*</small></label>
            <input type="text" class="form-control" id="org_name" name="org_name" placeholder="" required minlength="2">
        </div>
        </div>
      </div>

      <!-- Description of organization -->
      <div class="form-group col-md-12">
        <div class="form-group col-md-10">
          <label for="org_description"> <?php echo _("ORG_DESC") ?> <small class="required">(<?php echo _("400_CHAR") ?>)*</small></label>
          <textarea type="text" class="form-control " id="org_description" name="org_description" required></textarea>
        </div>
      </div>

      <!-- Type of organization -->
      <div class="form-group col-md-12" id="org_type">
          <label for="org_type"> <?php echo _("ORG_TYPE") ?><small class="required">*</small></label>
          <label id="org_type-error" class="error" for="org_type"></label>
        <div class="col-md-10">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default">
                <input type="radio" name="org_type" id="For-profit" value="For-profit" required="True">  <?php echo _("FOR-PROFIT") ?>
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_type" id="Nonprofit" value="Nonprofit">  <?php echo _("NONPROFIT") ?>
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_type" id="Developer group" value="Developer group">  <?php echo _("DEVELOPER_GROUP") ?>
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_type" id="Other" value="Other">  <?php echo _("OTHER") ?>
            </label>
          </div>
        </div>
      </div>

      <!-- Website URL -->
      <div class="form-group col-md-12">
        <label for="org_url"><?php echo _("WEBSITE_URL") ?></label>
        <div class="row">      
            <div class="col-md-8">
              <input type="url" class="form-control" id="org_url" name="org_url" placeholder="http://" value="http://">
            </div>
            <div class="col-md-4">
              <input type="checkbox" name="no_org_url" id="no_org_url" value="True"> <?php echo _("NO_URL") ?>
            </div>
        </div>
      </div>

      <!-- Location -->  
      <div class="form-group col-md-12">
        <div class="form-group col-md-10 details">

          <label for="org_hq_city_all"><?php echo _("LOCATION") ?> <small class="required">(<?php echo _("SPECIFIC_AS_POSSIBLE") ?>)*</small></label>
          <input type="text" class="form-control" id="org_hq_city_all" name="org_hq_city_all" required>

          <!--label for="org_hq_city">City</label -->
          <input type="hidden" class="form-control" id="org_hq_city" name="org_hq_city" data-geo="locality">

          <!--label for="org_hq_st_prov">State/Province</label -->
          <input type="hidden" class="form-control" id="org_hq_st_prov" name="org_hq_st_prov" data-geo="administrative_area_level_1">

          <!--label for="org_hq_country">Country</label-->
          <input type="hidden" class="form-control" id="org_hq_country" name="org_hq_country" data-geo="country">

          <!--label for="org_hq_country">Country code</label-->
          <input type="hidden" class="form-control" id="org_hq_country_locode" name="org_hq_country_locode" data-geo="country_short">

          <!--label for="latitude">lat</label -->
          <input type="hidden" class="form-control" id="latitude" name="latitude" data-geo="lat">
          <!--label for="longitude">lng</label -->
          <input type="hidden" class="form-control" id="longitude" name="longitude" data-geo="lng">
        </div>
      </div>
  
      <!-- Industry/category of organization -->
      <div class="form-group col-md-12">
        <label for="industry_id"><?php echo _("IND") ?> <small class="required">(<?php echo _("SELECT_1") ?>)*</small></label>
        <label id="industry_id-error" class="error" for="industry_id"></label>
        <fieldset>
        <div class="col-md-4" id="industry_id_col-1">
          <input type="radio" name="industry_id" class="industry_id" value="Agriculture">&nbsp; <?php echo _("AGR") ?>
          <br /><input type="radio" name="industry_id" class="industry_id" value="Arts and culture">&nbsp; <?php echo _("ART") ?>
          <br /><input id="industry_id_cul" type="radio" name="industry_id" class="industry_id" value="Business and legal services" required>&nbsp; <?php echo _("BUS") ?>
          <br /><input type="radio" name="industry_id" class="industry_id" value="Consumer services">&nbsp; <?php echo _("CSM") ?>
          <br /><input type="radio" name="industry_id" class="industry_id" value="Data/information technology">&nbsp; <?php echo _("DAT") ?>
          <br /><input type="radio" name="industry_id" class="industry_id" value="Education">&nbsp; <?php echo _("EDU") ?>
          <br /><input type="radio" name="industry_id" class="industry_id" value="Energy">&nbsp; <?php echo _("NGY") ?>
          <br /><input type="radio" name="industry_id" class="industry_id" value="Environment">&nbsp; <?php echo _("ENV") ?>
          <br /><input type="radio" name="industry_id" class="industry_id" value="Finance and investment">&nbsp; <?php echo _("FIN") ?>
        </div>
        <div class="col-md-4" id="industry_id_col-2">
          <input type="radio" name="industry_id" class="industry_id" value="Geospatial/mapping">&nbsp; <?php echo _("GEO") ?>
          <br /><input type="radio" name="industry_id" class="industry_id" value="Governance">&nbsp; <?php echo _("GOV") ?>
          <br /><input type="radio" name="industry_id" class="industry_id" value="Healthcare">&nbsp; <?php echo _("HLT") ?>
          <br /><input type="radio" name="industry_id" class="industry_id" value="Housing and real estate">&nbsp; <?php echo _("HOU") ?>
          <br /><input type="radio" name="industry_id" class="industry_id" value="Insurance">&nbsp; <?php echo _("INS") ?>
          <br /><input type="radio" name="industry_id" class="industry_id" value="Media and communications">&nbsp; <?php echo _("COM") ?>
          <br /><input type="radio" name="industry_id" class="industry_id" value="Mining/manufacturing">&nbsp; <?php echo _("MAN") ?>
          <br /><input type="radio" name="industry_id" class="industry_id" value="Research and consulting">&nbsp; <?php echo _("RSH") ?>
          <br /><input type="radio" name="industry_id" class="industry_id" value="Security and public safety">&nbsp; <?php echo _("SEC") ?>
        </div>
        <div class="col-md-4" id="industry_id_col-3">
          <input type="radio" name="industry_id" class="industry_id" value="Scientific research">&nbsp; <?php echo _("SCI") ?>
          <br /><input type="radio" name="industry_id" class="industry_id" value="Telecommunications/internet service providers (ISPs)">&nbsp; <?php echo _("TEL") ?>
          <br /><input type="radio" name="industry_id" class="industry_id" value="Tourism">&nbsp; <?php echo _("TOR") ?>
          <br /><input type="radio" name="industry_id" class="industry_id" value="Transportation and logistics">&nbsp; <?php echo _("TRN") ?>
          <br /><input type="radio" name="industry_id" class="industry_id" value="Water and sanitation">&nbsp; <?php echo _("WAT") ?>
          <br /><input type="radio" name="industry_id" class="industry_id" value="Weather">&nbsp; <?php echo _("WEA") ?>
          <br /><input type="radio" name="industry_id" class="industry_id" value="Other">&nbsp; <?php echo _("OTHER") ?>
                <input type="text" class="form-control" style="display:none" name="industry_other" placeholder="<?php echo _("PROVIDE_DETAILS") ?>">
        </div>
        </fieldset>
      </div>

      <!-- Founding year -->    
      <div class="form-group col-md-12">
        <div class="form-group col-md-10">
          <label for="org_year_founded"><?php echo _("FOUNDING_YEAR") ?><small class="required">*</small></label>
          <input type="text" class="form-control" id="org_year_founded" name="org_year_founded" placeholder="" required>
        </div>
      </div>

      <!-- Size -->
      <div class="form-group col-md-12">
        <label for="org_size_id"><?php echo _("SIZE") ?><small class="required">*</small></label>
        <label id="org_size_id-error" class="error" for="org_size_id"></label>
        <div class="col-md-12">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default">
                <input type="radio" name="org_size_id" value="1-10"> <?php echo _("1-10") ?>
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_size_id" value="11-50"> <?php echo _("11-50") ?>
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_size_id" value="51-200"> <?php echo _("51-200") ?>
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_size_id" value="201-1000"> <?php echo _("201-1000") ?>
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_size_id" value="1000+"> <?php echo _("1000+") ?>
            </label>
          </div>
        </div>
      </div>

      <!-- What is the greatest type of impact your organization has? -->
      <div class="form-group col-md-12" id="org_greatest_impact">
          <label for="org_greatest_impact"><?php echo _("GREATEST_IMPACT") ?><small class="required">*</small></label>
          <label id="org_greatest_impact-error" class="error" for="org_greatest_impact"></label>
        <div class="col-xs-9">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default">
                <input type="radio" name="org_greatest_impact" id="Economic" value="Economic" /> <?php echo _("ECONOMIC") ?>
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_greatest_impact" id="Environmental" value="Environmental" /> <?php echo _("ENVIRONMENTAL") ?>
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_greatest_impact" id="Governance" value="Governance" /> <?php echo _("GOVERNANCE") ?>
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_greatest_impact" id="Social" value="Social" /> <?php echo _("SOCIAL") ?>
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_greatest_impact" id="Other" value="Other" /> <?php echo _("OTHER") ?>
            </label>
          </div>
        </div>
        <div class="col-md-10" id="org_greatest_impact_detail_div"><input type="text" class="form-control" id="org_greatest_impact_detail" name="org_greatest_impact_detail" placeholder="<?php echo _("PROVIDE_DETAILS") ?>" required></div>
      </div>
    </div><!--/OrgInfo-->

<br />

    <div class="col-md-12" role="dataUse-titlebar"  id="role-dataUse-titlebar">
      <div class="section-title"><h3><?php echo _("USE_OF_OPEN_DATA") ?></h3></div>
    </div>

    <div class="col-md-12" role="dataUse" id="role-dataUse">
      
      <div class="row col-md-12 data-use-row" id="dataUseDataType">
        <label for="data_use_type[]"><?php echo _("MOST_RELEVANT_OPEN_DATA") ?> <small class="required">(<?php echo _("SELECT_ALL") ?>)*</small></label>
        <label id="data_use_type[]-error" class="error" for="data_use_type[]"></label>
        <div class="col-md-4" id="data_type_col-1">
            <input type="checkbox" name="data_use_type[]" class="data_use_type" value="Agriculture" required>&nbsp; <span><?php echo _("AGRICULTURE") ?></span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Arts and culture">&nbsp; <span><?php echo _("ARTS_AND_CULTURE") ?></span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Business">&nbsp; <span><?php echo _("BUSINESS") ?></span></span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Consumer">&nbsp; <span><?php echo _("CONSUMER") ?></span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Demographics and social">&nbsp; <span><?php echo _("DEMOGRAPHICS") ?></span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Economics ">&nbsp; <span><?php echo _("ECONOMICS") ?></span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Education">&nbsp; <span><?php echo _("EDUCATION") ?></span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Energy">&nbsp; <span><?php echo _("ENERGY") ?></span>
        </div>
        <div class="col-md-4" id="data_type_col-2">
            <input type="checkbox" name="data_use_type[]" class="data_use_type" value="Environment">&nbsp; <span><?php echo _("ENVIRONMENT") ?></span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Finance">&nbsp; <span><?php echo _("FINANCE") ?></span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Geospatial/mapping">&nbsp; <span><?php echo _("GEOSPATIAL") ?></span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Government operations">&nbsp; <span><?php echo _("GOVERNMENT_OPS") ?></span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Health/healthcare">&nbsp; <span><?php echo _("HEALTH") ?></span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Housing">&nbsp; <span><?php echo _("HOUSING_CAT") ?></span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="International/global development">&nbsp; <span><?php echo _("INTERNATIONAL") ?></span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Legal">&nbsp; <span><?php echo _("LEGAL") ?></span>
        </div>
        <div class="col-md-4" id="data_type_col-3">
            <input type="checkbox" name="data_use_type[]" class="data_use_type" value="Manufacturing">&nbsp; <span><?php echo _("MANUFACTURING") ?></span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Science and research">&nbsp; <span><?php echo _("SCIENCE_AND_RESEARCH") ?></span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Public safety">&nbsp; <span><?php echo _("PUBLIC_SAFETY") ?></span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Tourism">&nbsp; <span><?php echo _("TOURISM") ?></span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Transportation">&nbsp; <span><?php echo _("TRANSPORTATION") ?></span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Weather">&nbsp; <span><?php echo _("WEATHER") ?></span>
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Other">&nbsp; <span><?php echo _("OTHER") ?></span>
                  <input type="text" class="form-control" style="display:none" id="data_use_type_other" name="data_use_type_other" placeholder="<?php echo _("PROVIDE_DETAILS") ?>">
        </div>
      </div>
<br />
      <!-- Sources of open data -->
      <div class="form-group col-md-12">
        <label for="data_country_count"><?php echo _("NUM_OF_COUNTRIES") ?> <small class="required">*</small></label>
        <label id="data_country_count-error" class="error" for="data_country_count"></label>
        <div class="col-md-12">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default">
                <input type="radio" name="data_country_count" value="1" /> <?php echo _("1_COUNTRY") ?>
            </label>
            <label class="btn btn-default">
                <input type="radio" name="data_country_count" value="2 - 5" /> <?php echo _("2-5_COUNTRIES") ?>
            </label>
            <label class="btn btn-default">
                <input type="radio" name="data_country_count" value="6 - 10" /> <?php echo _("6-10_COUNTRIES") ?>
            </label>
            <label class="btn btn-default">
                <input type="radio" name="data_country_count" value="11 - 20" /> <?php echo _("11-20_COUNTRIES") ?>
            </label>
            <label class="btn btn-default">
                <input type="radio" name="data_country_count" value="21 - 50" /> <?php echo _("21-50_COUNTRIES") ?>
            </label>
            <label class="btn btn-default">
                <input type="radio" name="data_country_count" value="50+" /> <?php echo _("50+_COUNTRIES") ?>
            </label>
          </div>
        </div>
      </div>

      <div id="data_use_details"></div>

      <div class="row col-md-12">
        <label class="row col-md-10">
          <?php echo _("HOW_USE_OPEN_DATA") ?> <small class="required">(<?php echo _("PROVIDE_AS_MUCH_INFO") ?>)*</small> 
        </label>

        <div class="form-group col-md-12">
          <div class="col-md-6" id="use_open_data_col-1">
             <div>
              <input type="checkbox" class="use_open_data" name="use_advocacy" id="use_advocacy" value="True"> <?php echo _("ADVOCACY") ?>
              <textarea class="form-control" style="display:none" id="use_advocacy_desc" name="use_advocacy_desc" placeholder="<?php echo _("PROVIDE_DETAILS") ?>"></textarea>
            </div>
            <div>
              <input type="checkbox" class="use_open_data" name="use_prod_srvc" id="use_prod_srvc" value="True"> <?php echo _("PRODUCTS_SERVICES") ?>
              <textarea class="form-control" style="display:none" id="use_prod_srvc_desc" name="use_prod_srvc_desc" placeholder="<?php echo _("PROVIDE_DETAILS") ?>"></textarea>
            </div>
            <div>
              <input type="checkbox" class="use_open_data" name="use_org_opt" id="use_org_opt" value="True"> <?php echo _("ORG_OPTIMIZATION") ?> <i>(<?php echo _("EG_BENCHMARKING") ?>)</i>
              <textarea class="form-control" style="display:none" id="use_org_opt_desc" name="use_org_opt_desc" placeholder="<?php echo _("PROVIDE_DETAILS") ?>"></textarea>
            </div>
          </div>

          <div class="col-md-6" id="use_open_data_col-2">
            <div>
              <input type="checkbox" class="use_open_data" name="use_research" id="use_research" value="True"> <?php echo _("RESEARCH") ?>
              <textarea class="form-control" style="display:none" id="use_research_desc" name="use_research_desc" placeholder="<?php echo _("PROVIDE_DETAILS") ?>"></textarea>
            </div>
            <div>
              <input type="checkbox" class="use_open_data" name="use_other" id="use_other" value="True"> <?php echo _("OTHER") ?>
              <textarea class="form-control" style="display:none" id="use_other_desc" name="use_other_desc" placeholder="<?php echo _("PROVIDE_DETAILS") ?>"></textarea>
            </div>
          </div>
        </div>
      </div>

      <!-- Additional description --> 
      <div class="row col-md-12">
        <label class="row col-md-10">
          <?php echo _("ADDITIONAL_INFORMATION") ?> <small class="optional">(<?php echo _("OPTIONAL") ?>, <?php echo _("400_CHAR") ?>)</small>
        </label>

        <div class="row col-md-10">
          <textarea type="text" class="form-control" id="org_additional" name="org_additional" placeholder="<?php echo _("EG_HOW_COULD") ?> <?php echo _("WHICH_DATASETS_MOST_VALUABLE") ?> <?php echo _("WHAT_OTHER_TYPES_OF_DATA") ?>"></textarea>
        </div>
      </div>
      <br />
    </div>

    <br />
 
    <div class="col-md-12" role="contact-titlebar"  id="role-contact-titlebar">
      <div class="section-title"><h3>3. <?php echo _("CONTACT_INFORMATION") ?> <small>(<?php echo _("NOT_BE_MADE_PUBLIC") ?>)</small></h3></div>
    </div>

    <div class="col-md-12" role="contact" id="role-contact">

      <div class="form-group col-md-12">
        <div class="col-md-5">
          <div for="survey_contact_first"><?php echo _("FIRST_NAME") ?><small class="required">*</small></div>
          <input type="text" class="form-control" id="survey_contact_first" name="survey_contact_first" required>
        </div>

        <div class="col-md-5">
          <div for="survey_contact_last"><?php echo _("LAST_NAME") ?><small class="required">*</small></div>
          <input type="text" class="form-control" id="survey_contact_last" name="survey_contact_last" required>
        </div>

        <div class="col-md-10">
          <div for="survey_contact_title"><?php echo _("TITLE") ?> <i>(<?php echo _("OPTIONAL") ?>)</i></div>
          <input type="text" class="form-control" id="survey_contact_title" name="survey_contact_title">

          <div for="survey_contact_email"><?php echo _("EMAIL") ?><small class="required">*</small></div>
          <input type="email" class="form-control" id="survey_contact_email" name="survey_contact_email" required>

          <div for="survey_contact_email"><?php echo _("PHONE") ?> <i>(<?php echo _("OPTIONAL") ?>)</i></div>
          <input type="text" class="form-control" id="survey_contact_phone" name="survey_contact_phone">

          <input type="hidden" class="form-control" id="org_profile_year" name="org_profile_year" value="2015">
          <input type="hidden" class="form-control" id="org_profile_status" name="org_profile_status" value="submitted">
          <input type="hidden" class="form-control" id="org_profile_src" name="org_profile_src" value="survey">
          <input type="hidden" class="form-control" id="org_profile_src" name="org_profile_category" value="submitted survey">
        </div>
      </div>
    </div><!-- /closes role contact -->
      
      <br />

    <div class="col-md-12" role="submit-note" id="role-submit-note">
      <div style="text-align:center;font-size:16px;margin-top:20px;">
        <b><i><?php echo _("SUBMISSIONS_REVIEWED") ?></i></b>
      </div>
      <br />
    </div>

    <div class="col-md-12" style="text-align:center;">    
      <button class="btn btn-primary" style="padding:1em 2em 1em 2em; width:200px; background-color: rgb(53, 162, 227);" id="btnSubmit" type="submit" name="submit" value="submit"><?php echo _("SUBMIT") ?></button>
    </div>

    <div class="w-section attribution" style="margin-top:12px;">
      <div class="w-container">
        <div class="">
          <hr>
          <div class="w-row row-attribution" >
            <div class="w-col w-col-3"><a href="http://od4d.net"><img class="logo-od4" src="/map/survey/img/od4-logo-black.png" width="200"></a>
            </div>
            <div class="w-col w-col-3" style="text-align:center;"><a class="link-attribution" href="http://creativecommons.org/licenses/by-sa/4.0/"><img class="logo-cc" src="/map/survey/img/creative_commons_logo.png" width="150"></a>
            </div>
            <div class="w-col w-col-6">
              <div class="text-attribution"><?php echo _("OD4D_ATTRIBUTION") ?>&nbsp;<a class="link-attribution" href="http://creativecommons.org/licenses/by-sa/4.0/"><?php echo _("CREATIVE_COMMONS_LICENSE") ?></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
      
    </div>

</form>

</div> 
<!-- I think I am missing a closing </div> gut things are working. -->
<!-- end container - where is the tag? -->

<?php include __DIR__.'/'.'tp_pt_footer.php'; ?>

