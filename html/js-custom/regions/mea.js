(function ($, config) {
  var region = 'Middle East & North Africa';

  // Coordinates defining bounds of map draggability.
  var lowerBound = [8, -23];
  var upperBound = [43, 70];
  var bounds = [lowerBound, upperBound];

  // Coordinate for default viewpoint.
  var view = [26, 24];

  renderCounter('region', region, config);
  renderRegionOrgMap(region, regionGeoJSON, bounds, view, config);
  renderPieCharts('region', region, config);
  renderRegionBarCharts(region);
  renderUseCases('region', region, config);
})(jQuery, config);