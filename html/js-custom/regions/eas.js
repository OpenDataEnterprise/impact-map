(function ($, config) {
  var region = 'East Asia & Pacific';

  // Coordinates defining bounds of map draggability.
  var lowerBound = [-60, 60];
  var upperBound = [60, 200];
  var bounds = [lowerBound, upperBound];
  
  // Coordinate for default viewpoint.
  var view = [4, 143];

  renderCounter('region', region, config);
  renderRegionOrgMap(region, regionGeoJSON, bounds, view, config);
  renderPieCharts('region', region, config);
  renderRegionBarCharts(region, config);
  renderUseCases('region', region, config);
})(jQuery, config);