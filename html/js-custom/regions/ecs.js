(function ($, config) {
  var region = 'Europe & Central Asia';

  // Coordinates defining bounds of map draggability.
  var lowerBound = [20, -90];
  var upperBound = [90, 180];
  var bounds = [lowerBound, upperBound];
  
  // Coordinate for default viewpoint.
  var view = [45, 30];

  renderCounter('region', region, config);
  renderRegionOrgMap(region, regionGeoJSON, bounds, view, config);
  renderPieCharts('region', region, config);
  renderRegionBarCharts(region, config);
  renderUseCases('region', region, config);
})(jQuery, config);