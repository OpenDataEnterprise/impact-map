(function ($, config) {
  var region = 'Latin America & Caribbean';

  // Coordinates defining bounds of map draggability.
  var lowerBound = [-65, -135];
  var upperBound = [40, -25];
  var bounds = [lowerBound, upperBound];

  // Coordinate for default viewpoint.
  var view = [-22, -60];

  renderCounter('region', region, config);
  renderRegionOrgMap(region, regionGeoJSON, bounds, view, config);
  renderPieCharts('region', region, config);
  renderRegionBarCharts(region, config);
  renderUseCases('region', region, config);
})(jQuery, config);