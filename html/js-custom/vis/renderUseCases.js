function renderUseCases (type, category, config) {
  function getNestedValue (object, keys) {
    return keys.reduce(
      (obj, key) => (obj && key in obj) ? obj[key] : undefined, object);
  }

  function processData (results) {
    $.each(results, function (index, result) {
        var title = result.name;
        var image = result.image_url;
        var subtitle = result.short_description;
        var url = result.url;
        var country = getNestedValue(result, ['country', 'name']);
        var regionAbbr = getNestedValue(result,
          ['country', 'region', 'abbreviation']);
        var sector = getNestedValue(result,
          ['sector', 'sector']);
        var impact = result.impact;
        var dataUse = result.data_used;
        var description = result.long_description;
        var machineReadable = result.machine_readable;

        var underscoreTitle = title.replace(/[\.\s\(\){}]/g, '');

      // clone and append template container, also add data to it
      $('#template')
        .clone(true)
        .removeAttr('id')
        .attr('id', 'use-cases' + index)
        .appendTo('.text-container');
      $('img', "#use-cases" + index)
        .attr('src', 'useCaseImage/' + image);
      $("#use-cases" + index)
        .find('h3.case-study-title')
        .text(title);
      $("#use-cases" + index)
        .find('div.case-study-subtitle')
        .text(subtitle);
      $("#use-cases" + index)
        .find('a#useCaseURL')
        .text(url)
        .attr('href', url);
      $("#use-cases" + index)
        .find('p#countryPara')
        .html('<strong>Country:</strong> ' + country);
      $("#use-cases" + index)
        .find('p#impactPara')
        .html('<strong>Impact:</strong> ' + impact);
      $("#use-cases" + index)
        .find('p#dataUsePara')
        .html('<strong>Data Used:</strong> ' + dataUse);
      $("#use-cases" + index)
        .find('p#mainPara')
        .html(description);
    });

    // remove the template container
    $('#template').remove();

    // interactions for show and hide buttons
    $('.read-more-button-1').on('click', function() {
      $(this).hide();
    });
    $('.read-more-button-1').on('click', function() {
      $(this).parent().find('img.case-study-thumbnail-image-1').hide();
    });
    $('.read-more-button-1').on('click', function() {
      $(this).parent().find('div.case-study-body-1').show();
    });
    $('.read-more-button-1').on('click', function() {
      $(this).parent().find('a.show-less-button-1').show();
    });

    $('.show-less-button-1').on('click', function() {
      $(this).parent().find('div.case-study-body-1').hide();
    });
    $('.show-less-button-1').on('click', function() {
      $(this).hide();
    });
    $('.show-less-button-1').on('click', function() {
      $(this).parent().find('a.read-more-button-1').show();
    });
    $('.show-less-button-1').on('click', function() {
      $(this).parent().find('img.case-study-thumbnail-image-1').show();
    });
  }

  $(document).ready(function () {
    var apiBaseURL = config.apiBaseURL; 
    var queryURL = apiBaseURL + type + '/' + category + '/use-cases';

    $.ajax({
      url: queryURL,
      success: function (data) {
        processData(data);
      }
    });
  });
}