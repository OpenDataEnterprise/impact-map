<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js" type="text/javascript"></script>  
<!--[if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif]-->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>  
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')</script>
<script src="/survey/js/vendor/bootstrap.min.js"></script>
<script src="/survey/js/plugins.js"></script>
<script>
  // Prepare _i18n localization object for use in main.js
  // NOTE: _i18n must be prepared before main.js called
  var _i18n = {
    "SELECT_COUNTRIES_PROVIDING_DATA": "<?php echo _('SELECT_COUNTRIES_PROVIDING_DATA') ?>",
    "SHOW_GOVERNMENT_LEVEL": "<?php echo _('SHOW_GOVERNMENT_LEVEL') ?>",
    "DATA_SOURCE_COUNTRY": "<?php echo _('DATA_SOURCE_COUNTRY') ?>",
    "SELECT": "<?php echo _('SELECT') ?>"
  }

</script>
<script src="/survey/js/main.js"></script>

<!-- select2 library -->
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/css/select2.min.css" rel="stylesheet" />
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/js/select2.min.js"></script>
<script src="/survey/dist/jquery.validate.min.js"></script>
<?php if ($language == "fr_FR") { ?>
<script src="/survey/js/vendor/jquery-validation/src/localization/messages_fr.js"></script>
<?php } elseif ($language == "es_MX") { ?>
<script src="/survey/js/vendor/jquery-validation/src/localization/messages_es.js"></script>
<?php } ?>

<!-- geocomplete -->
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyD36Jq79omYvK4q160enCpKcdzeuhlCu7U&amp;sensor=false&amp;libraries=places&amp;language=<?php echo $content['language']; ?>"></script>
<script src="/survey/js/vendor/ubilabs-geocomplete-eb38f45/jquery.geocomplete.js"></script>
  
<!-- onscreen guidance chardin.js -->
<link href="/survey/css/chardinjs.css" rel="stylesheet">
<script src="/survey/js/chardinjs.min.js"></script>

<!-- custom -->
<script>
  $(document).ready(function() {

    // Select 2 selection boxes
    $(".basic-single-industry").select2(
      { placeholder: "Select an industry",
      allowClear: true }
    );

    $(".js-example-basic-single").select2( 
      { placeholder: "<?php echo _('SELECT') ?>",
      allowClear: true }
    );

    // override jquery validate plugin defaults
    $.validator.setDefaults({
      ignore: [],
        highlight: function(element) {
          $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
          $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'label',
        // errorClass: 'help-block',
        errorPlacement: function(error, element) {
          if(element.parent('.btn-group').length) {
              error.insertAfter(element.parent());
          } else {
              error.insertAfter(element);
          }
        }
    });

    // Form Data validation
    $("#survey_form").validate({
      rules: {
        org_type: {
          required: true
        },
        org_size_id: {
          required: true
        },
        org_greatest_impact: {
          required: true
        },
        data_country_count: {
          required: true
        },
        org_year_founded: {
          required: true,
          digits: true,
          rangelength: [4, 4]
        },
        industry_other: {
          required: "#industr_id_other:checked",
          minlength: 2
        },
        data_use_type_other: {
          required: "#data_use_type_checkbox_other:checked",
          minlength: 2
        }
      },
      messages: {
        org_year_founded: "Enter a year using four digits, example: 1980",
        industry_other: "Describe other is required",
        data_use_type_other: "Describe other is required"
      }
    });

    // Geocomplete
    $('#org_hq_city_all').geocomplete({ 
      details: ".details",
      detailsAttribute: "data-geo"
    });

    // Toggle detail fields for use of open data question
    $('.use_open_data').click(function(e) {
      $('#'+this.id+'_desc').toggle(this.checked);
      if ($('#'+this.id+'_desc').is(":hidden")) {
        $('#'+this.id+'_desc').val("");
      }
    });

    // Toggle other choice for industry/category
    $('.industry_id').on('change', function(e) {
      var choice = $('input[name="industry_id"]:checked').val();
      if (choice != 'Other' && $('input[name="industry_other"]').is(":visible")) {
        $('input[name="industry_other"]').val("");
        $('input[name="industry_other"]').toggle();
      }
      if (choice == 'Other' && $('input[name="industry_other"]').is(":hidden")) {
        $('input[name="industry_other"]').val("");
        $('input[name="industry_other"]').toggle();
      }
    });

    // Toggle other choice for most relevant types of open data
    $('#data_use_type_checkbox_other').on('change', function(e) {
      var choice = $('#data_use_type_checkbox_other:checked').val();
      if (choice != 'Other' && $('input[name="data_use_type_other"]').is(":visible")) {
        $('input[name="data_use_type_other"]').val("");
        $('input[name="data_use_type_other"]').toggle();
      }
      if (choice == 'Other' && $('input[name="data_use_type_other"]').is(":hidden")) {
        $('input[name="data_use_type_other"]').val("");
        $('input[name="data_use_type_other"]').toggle();
      }
    });

    $('input[type=radio][name=org_type]').change(function() {
      if (this.value == 'Other') {
        if ($('#org_type_other_div').length == 0) {
          var new_html = '<div class="col-md-4" id="org_type_other_div"><input type="text" class="form-control" id="org_type_other" name="org_type_other" placeholder="Provide other" required></div>';
          $('#org_type').append(new_html);
        }
      }
      else {
        if ( $('#org_type_other_div').length > 0 ) {
          $('#org_type_other_div').remove();
        }
      }
      $('#org_type-error').html("");
    });

    $('input[type=radio][name=org_size_id]').change(function() {
      $('#org_size_id-error').html("");
    });

    // Use of Open Data Interactivity
    $('input[type=checkbox][class=data_use_type]').change(function(e) {
      updateDataUseProfile(e);
    });
      
    $('input[name="data_use_type_other"]').change(function(e) {
    });

    $('input[type=radio][name=data_country_count]').change(function(e) {
      $('#data_country_count-error').html("");
      updateDataUseProfile(e);
    });
  }); // End Document Ready function

</script>
<!--[if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif]-->
<script>
  $('.custom-button').on('click', function (evt) {
    $('.target-tab-link').triggerHandler('click');
    evt.preventDefault();
  });
  $('.custom-button-2').on('click', function (evt) {
    $('.target-tab-link-2').triggerHandler('click');
    evt.preventDefault();
  });
</script>