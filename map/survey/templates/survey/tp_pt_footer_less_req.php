</footer>
<footer class="w-section section footer">
<!--   <div class="w-container footer-container">
    <div class="circle-logo"><img class="logo footer" src="/images/Logo-Mark.png" width="60">
    </div>
    <div class="brand-container footer"><img class="logo" src="/images/Logo-Text.png" width="320">
    </div>
  </div>
 -->  
  <div class="legal-wrapper">
    <div>© 2015 The Center for Open Data Enterprise&nbsp;1110 Vermont Avenue NW, Suite 500, Washington, DC 20005</div>
  </div>
</footer>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type="text/javascript" src="/js/webflow.js"></script>


  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')</script>
  <script src="/map/survey/js/vendor/bootstrap.min.js"></script>
  <script src="/map/survey/js/plugins.js"></script>
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
  <script src="/map/survey/js/main.js"></script>

  <!-- select2 library -->
  <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/css/select2.min.css" rel="stylesheet" />
  <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/js/select2.min.js"></script>
  <script src="/map/survey/dist/jquery.validate.min.js"></script>
<?php if ($language == "fr_FR") { ?>
  <script src="/map/survey/js/vendor/jquery-validation/src/localization/messages_fr.js"></script>
<?php } elseif ($language == "es_MX") { ?>
  <script src="/map/survey/js/vendor/jquery-validation/src/localization/messages_es.js"></script>
<?php } ?>

  <!-- geocomplete -->
  <script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&language=<?php echo $content['language']; ?>"></script>
  <script src="/map/survey/js/vendor/ubilabs-geocomplete-eb38f45/jquery.geocomplete.js"></script>
  
  <!-- onscreen guidance chardin.js -->
  <link href="/map/survey/css/chardinjs.css" rel="stylesheet">
  <script src="/map/survey/js/chardinjs.min.js"></script>

  <!-- custom -->
  <script>

    // Google analytics
    // var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
    // (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    // g.src='//www.google-analytics.com/ga.js';
    // s.parentNode.insertBefore(g,s)}(document,'script'));

    $( document ).ready(function() {

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

      // // Form Data validation
      // $("#survey_form").validate();
      $("#survey_form").validate({
        rules: {
          // txtTextOnly: {
          //   required: true,
          //   textOnly: true
          // },
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
        // alert(this.id);
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
            // console.log($('#industry_id').parent());
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

      // $('input[type=radio][name=org_greatest_impact]').change(function() {
      //   if ( $('#org_greatest_impact_detail_div').length == 0 ) {
      //     var new_html = '<div class="col-md-10" id="org_greatest_impact_detail_div"><input type="text" class="form-control" id="org_greatest_impact_detail" name="org_greatest_impact_other" placeholder="<?php echo _("PROVIDE_DETAILS") ?>" required></div>';
      //     // console.log($('#industry_id').parent());
      //     $('#org_greatest_impact').append(new_html);
      //   }
      //   $('#org_greatest_impact-error').html("");
      // });

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
 </body>
</html>
