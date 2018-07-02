(function ($, config) {
  var region = 'North America';

  // Coordinates defining bounds of map draggability.
  var lowerBound = [15, -185];
  var upperBound = [84, -50];
  var bounds = [lowerBound, upperBound];

  // Coordinate for default viewpoint.
  var view = [55, -105];

  renderCounter('region', region, config);
  renderRegionOrgMap(region, regionGeoJSON, bounds, view, config);
  renderPieCharts('region', region, config);
  renderRegionBarCharts(region, config);
  renderUseCases('region', region, config);
})(jQuery, config);