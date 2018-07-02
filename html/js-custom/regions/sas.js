(function ($, config) {
  var region = 'South Asia';

  // Coordinates defining bounds of map draggability.
  var lowerBound = [-3, 56];
  var upperBound = [40, 101];
  var bounds = [lowerBound, upperBound];

  // Coordinate for default viewpoint.
  var view = [20, 81];

  renderCounter('region', region, config);
  renderRegionOrgMap(region, regionGeoJSON, bounds, view, config);
  renderPieCharts('region', region, config);
  renderRegionBarCharts(region, config);
  renderUseCases('region', region, config);
})(jQuery, config);