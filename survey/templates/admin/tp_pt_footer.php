<footer class="w-section nav-bar footer-section">
<a name="footer"></a>

  <div class="container col-md-12 footer-container">
    &copy; Center for Open Data Enterprise 2015. All Rights Reserved.
  </div>

</footer>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')</script>
  <script src="/js/vendor/bootstrap.min.js"></script>
  <script src="/js/plugins.js"></script>
  <script src="/js/main.js"></script>

  <!-- select2 library -->
  <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/css/select2.min.css" rel="stylesheet" />
  <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/js/select2.min.js"></script>
  <script src="/dist/jquery.validate.min.js"></script>

  <!-- geocomplete -->
  <script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
  <script src="/js/vendor/ubilabs-geocomplete-eb38f45/jquery.geocomplete.js"></script>
  
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
        { placeholder: "Select",
        allowClear: true }
      );

      // Form Data validation
      $("#survey_form").validate();

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
        if (choice != 'otr' && $('input[name="industry_other"]').is(":visible")) {
          $('input[name="industry_other"]').val("");
          $('input[name="industry_other"]').toggle();
        }
        if (choice == 'otr' && $('input[name="industry_other"]').is(":hidden")) {
          $('input[name="industry_other"]').val("");
          $('input[name="industry_other"]').toggle();
        }
      });

      // Toggle other choice for most relevant types of open data
      $('input[value="Other"]').on('change', function(e) {
        var choice = $('input[value="Other"]:checked').val();
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
      });

      $('input[type=radio][name=org_greatest_impact]').change(function() {
        if ( $('#org_greatest_impact_detail_div').length == 0 ) {
          var new_html = '<div class="col-md-4" id="org_greatest_impact_detail_div"><input type="text" class="form-control" id="org_greatest_impact_detail" name="org_greatest_impact_other" placeholder="Provide details" required></div>';
          // console.log($('#industry_id').parent());
          $('#org_greatest_impact').append(new_html);
        }
      });

      // Use of Open Data Interactivity
      $('input[type=checkbox][class=data_use_type]').change(function(e) {
        updateDataUseProfile(e);
      });
      
      $('input[name="data_use_type_other"]').change(function(e) {
        updateDataUseProfile(e);
      });

      $('input[type=radio][name=data_country_count]').change(function(e) {
        updateDataUseProfile(e);
      });
    }); // End Document Ready function

  </script>
 </body>
</html>
