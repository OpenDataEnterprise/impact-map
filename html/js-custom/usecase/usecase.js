$(document).ready(function() {
  function getNestedValue (object, keys) {
    return keys.reduce(
      (obj, key) => (obj && key in obj) ? obj[key] : undefined, object);
  }

  function getRegionAbbr (regionObj) {
    var regionAbbr = getNestedValue(regionObj, ['abbreviation']);

    if (typeof regionAbbr !== 'undefined') {
      regionAbbr = regionAbbr.toLowerCase();
    }

    return regionAbbr;
  }

  $.ajax({
    url: 'http://localhost:3000/api/v1/use-cases',
    success: function(results) {
      $.each(results, function(index, result) {
        var title = getNestedValue(result, ['profile', 'org_name']);
        var image = getNestedValue(result, ['image_url']);
        var subtitle = getNestedValue(result, ['short_description']);
        var url = getNestedValue(result, ['profile', 'org_url']);
        var country = getNestedValue(result,
          ['profile', 'location', 'country', 'name']);
        var sector = getNestedValue(result,
          ['profile', 'industry', 'industry']);
        var impact = getNestedValue(result, ['impact']);
        var dataUse = getNestedValue(result, ['data_used']);
        var description = getNestedValue(result, ['long_description']);
        var machineReadable = getNestedValue(result,
          ['profile', 'machine_readable']);

        var underscoreTitle = title.replace(/[\.\s\(\){}]/g, '');

        // clone template / remove old ID / add new ID - new ID is also used in generating URL for this case popup at line 553
        $("#templateAbc").clone(true).removeAttr('id').attr('id', underscoreTitle).appendTo(".abc-case-container");

        // append data into the container
        $('img', "#"+underscoreTitle).attr('src', 'useCaseImage/' + image);
        $("#"+underscoreTitle).find('h3.case-study-title').text(title);
        $("#"+underscoreTitle).find('h1.expand-case-header').text(title);
        $("#"+underscoreTitle).find('div.case-study-subtitle').text(subtitle);
        $("#"+underscoreTitle).find('div.full-use-case-para').text(subtitle);
        $("#"+underscoreTitle).find('a.useCaseURL').text(url).attr('href', url);
        $("#"+underscoreTitle).find('p.countryMark').html('<strong>Country:</strong> ' + country);
        $("#"+underscoreTitle).find('p.sectorMark').html('<strong>Sector:</strong> ' + sector);
        $("#"+underscoreTitle).find('p.impactMark').html('<strong>Impact:</strong> ' + impact);
        $("#"+underscoreTitle).find('p.dataMark').html('<strong>Data Used:</strong> ' + dataUse);
        $("#"+underscoreTitle).find('p.longDesc').html(description);

        var regionObj = getNestedValue(
          result, ['profile', 'location', 'country', 'region']);
        var regionAbbr = getRegionAbbr(regionObj);

        $('#templateRegion')
          .clone(true)
          .removeAttr('id')
          .attr('id', 'region' + index)
          .appendTo('.' + regionAbbr + '-case-container');

        $('img', '#region' + index).attr('src', 'useCaseImage/' + image);
        $('#region' + index).find('h3.case-study-title').text(title);
        $('#region' + index).find('h1.expand-case-header').text(title);
        $('#region' + index).find('div.case-study-subtitle').text(subtitle);
        $('#region' + index).find('div.full-use-case-para').text(subtitle);
        $('#region' + index).find('a.useCaseURL').text(url).attr('href', url);
        $('#region' + index).find('p.countryMark').html('<strong>Country:</strong> ' + country);
        $('#region' + index).find('p.sectorMark').html('<strong>Sector:</strong> ' + sector);
        $('#region' + index).find('p.impactMark').html('<strong>Impact:</strong> ' + impact);
        $('#region' + index).find('p.dataMark').html('<strong>Data Used:</strong> ' + dataUse);
        $('#region' + index).find('p.longDesc').html(description);

        var sectorContainerMap = {
          'Agriculture': '.agri-row-container',
          'Arts, culture and tourism': '.act-row-container',
          'Business, research and consulting': '.brc-row-container',
          'Consumer': '.consu-row-container',
          'Education': '.edu-row-container',
          'Energy and climate': '.ec-row-container',
          'Finance and insurance': '.fi-row-container',
          'Governance': '.gov-row-container',
          'Healthcare': '.heal-row-container',
          'Housing, construction & real estate': '.hcr-row-container',
          'IT and geospatial': '.ig-row-container',
          'Media and communications': '.mc-row-container',
          'Transportation and logistics': '.tl-row-container',
        };

        if (sector && sector in sectorContainerMap) {
          var sectorContainerName = sectorContainerMap[sector];

          $('#templateSector')
            .clone(true)
            .removeAttr('id')
            .attr('id', 'sector' + index)
            .appendTo(sectorContainerName);

          $('img', '#sector' + index).attr('src', 'useCaseImage/' + image);
          $('#sector' + index).find('h3.case-study-title').text(title);
          $('#sector' + index).find('h1.expand-case-header').text(title);
          $('#sector' + index).find('div.case-study-subtitle').text(subtitle);
          $('#sector' + index).find('div.full-use-case-para').text(subtitle);
          $('#sector' + index).find('a.useCaseURL').text(url).attr('href', url);
          $('#sector' + index).find('p.countryMark').html('<strong>Country:</strong> ' + country);
          $('#sector' + index).find('p.sectorMark').html('<strong>Sector:</strong> ' + sector);
          $('#sector' + index).find('p.impactMark').html('<strong>Impact:</strong> ' + impact);
          $('#sector' + index).find('p.dataMark').html('<strong>Data Used:</strong> ' + dataUse);
          $('#sector' + index).find('p.longDesc').html(description);
        }

        var mrContainerMap = {
          'Agriculture': '.agri-mr-container',
          'Arts, culture and tourism': '.act-mr-container',
          'Business, research and consulting': '.brc-mr-container',
          'Consumer': '.consu-mr-container',
          'Education': '.edu-mr-container',
          'Energy and climate': '.ec-mr-container',
          'Finance and insurance': '.fi-mr-container',
          'Governance': '.gov-mr-container',
          'Healthcare': '.heal-mr-container',
          'Housing, construction & real estate': '.hcr-mr-container',
          'IT and geospatial': '.ig-mr-container',
          'Media and communications': '.mc-mr-container',
          'Transportation and logistics': '.tl-mr-container',
        };

        if (machineReadable === 'Yes') {
          var mrContainerName = mrContainerMap[sector];

          $(mrContainerName).show();
          $('#templateMrble')
            .clone(true)
            .removeAttr('id')
            .attr('id', 'mrble' + index)
            .appendTo(mrContainerName);

          $('img', '#mrble' + index).attr('src', 'useCaseImage/' + image);
          $('#mrble' + index).find('h3.case-study-title').text(title);
          $('#mrble' + index).find('h1.expand-case-header').text(title);
          $('#mrble' + index).find('div.case-study-subtitle').text(subtitle);
          $('#mrble' + index).find('div.full-use-case-para').text(subtitle);
          $('#mrble' + index).find('a.useCaseURL').text(url).attr('href', url);
          $('#mrble' + index).find('p.countryMark').html('<strong>Country:</strong> ' + country);
          $('#mrble' + index).find('p.sectorMark').html('<strong>Sector:</strong> ' + sector);
          $('#mrble' + index).find('p.impactMark').html('<strong>Impact:</strong> ' + impact);
          $('#mrble' + index).find('p.dataMark').html('<strong>Data Used:</strong> ' + dataUse);
          $('#mrble' + index).find('p.longDesc').html(description);
        }
      });

      // remove template containers
      $('#templateAbc').remove();
      $('#templateRegion').remove();
      $('#templateSector').remove();
      $('#templateMrble').remove();

      // interactions for show.hide modal popup
      // fill address bar with the URL for this use case using the same rule as in index.php
      $('.case-study-intro-1').on('click', function() {
        $(this).parent().find('div.modal-wrapper').show();
        var caseId = $(this).parent().attr('id');
        var stateObj = { foo: 'bar' };
        history.pushState(stateObj, '', '/usecases/' + caseId);
      });
      // revert the URL in the address bar back to use case page URL
      $('.close-case-modal').on('click', function() {
        $('.modal-wrapper').hide();
        var stateObj = { foo: 'bar' };
        history.pushState(stateObj, '', '/usecases');
      });

      // show/hide four view containers and color interactions for four new filter buttons
      // first - alphabetical
      $('#byTitle').on('click', function() {
        $(this).css('background-color', '#50b094');
        $('#byRegion').css('background-color', '#376d86');
        $('#bySector').css('background-color', '#376d86');
        $('#byMR').css('background-color', '#376d86');

        $('.abc-case-container').show();
        $('.region-case-container').hide();
        $('.sector-case-container').hide();
        $('.mrble-case-container').hide();
      });

      //second -  by region
      $('#byRegion').on('click', function() {
        $(this).css('background-color', '#50b094');
        $('#byTitle').css('background-color', '#376d86');
        $('#bySector').css('background-color', '#376d86');
        $('#byMR').css('background-color', '#376d86');

        $('.abc-case-container').hide();
        $('.region-case-container').show();
        $('.sector-case-container').hide();
        $('.mrble-case-container').hide();
      });

      //third - by sector
      $('#bySector').on('click', function() {
        $(this).css('background-color', '#50b094');
        $('#byRegion').css('background-color', '#376d86');
        $('#byTitle').css('background-color', '#376d86');
        $('#byMR').css('background-color', '#376d86');

        $('.abc-case-container').hide();
        $('.region-case-container').hide();
        $('.sector-case-container').show();
        $('.mrble-case-container').hide();
      });

      //fourth - all machine readable use cases
      $('#byMR').on('click', function() {
        $(this).css('background-color', '#50b094');
        $('#byRegion').css('background-color', '#376d86');
        $('#bySector').css('background-color', '#376d86');
        $('#byTitle').css('background-color', '#376d86');

        $('.abc-case-container').hide();
        $('.region-case-container').hide();
        $('.sector-case-container').hide();
        $('.mrble-case-container').show();
      });

      // show machine readability case view (or not) based on URL hash value
      var urlHash = window.location.hash;
      if (urlHash === '#MachineReadabilityProject' || urlHash === '#MachineReadable') {
        $('#byMR').css('background-color', '#50b094');
        $('#byRegion').css('background-color', '#376d86');
        $('#bySector').css('background-color', '#376d86');
        $('#byTitle').css('background-color', '#376d86');

        $('.abc-case-container').hide();
        $('.region-case-container').hide();
        $('.sector-case-container').hide();
        $('.mrble-case-container').show();
      } else if (urlHash && urlHash!=='#MachineReadabilityProject') {
        $('#byMR').css('background-color', '#376d86');
        $('#byRegion').css('background-color', '#376d86');
        $('#bySector').css('background-color', '#376d86');
        $('#byTitle').css('background-color', '#50b094');

        $('.abc-case-container').show();
        $('.region-case-container').hide();
        $('.sector-case-container').hide();
        $('.mrble-case-container').hide();

        $(urlHash).find('div.modal-wrapper').show();  
      } else {
        $('#byMR').css('background-color', '#376d86');
        $('#byRegion').css('background-color', '#376d86');
        $('#bySector').css('background-color', '#376d86');
        $('#byTitle').css('background-color', '#50b094');

        $('.abc-case-container').show();
        $('.region-case-container').hide();
        $('.sector-case-container').hide();
        $('.mrble-case-container').hide();
      }
    }
  });
});