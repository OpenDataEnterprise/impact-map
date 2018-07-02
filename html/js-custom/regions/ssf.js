(function ($, config) {
  var region = 'Sub-Saharan Africa';

  // Coordinates defining bounds of map draggability.
  var lowerBound = [-50, -21];
  var upperBound = [30, 67];
  var bounds = [lowerBound, upperBound];

  // Coordinate for default viewpoint.
  var view = [0, 33];

  renderCounter('region', region, config);
  renderRegionOrgMap(region, regionGeoJSON, bounds, view, config);
  renderPieCharts('region', region, config);
  renderRegionBarCharts(region, config);
  renderUseCases('region', region, config);
})(jQuery, config);