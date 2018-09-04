import { renderRegionPage } from 'renderRegionPage';

(function () {
  let region = 'South Asia';

  // Coordinates defining bounds of map draggability.
  let lowerBound = [-3, 56];
  let upperBound = [40, 101];
  let bounds = [lowerBound, upperBound];

  // Coordinate for default viewpoint.
  let view = [20, 81];

  renderRegionPage(region, 1160, 400, bounds, view, regionGeoJSON);
})();