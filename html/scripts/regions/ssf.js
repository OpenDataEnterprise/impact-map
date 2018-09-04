import { renderRegionPage } from 'renderRegionPage';

(function () {
  let region = 'Sub-Saharan Africa';

  // Coordinates defining bounds of map draggability.
  let lowerBound = [-50, -21];
  let upperBound = [30, 67];
  let bounds = [lowerBound, upperBound];

  // Coordinate for default viewpoint.
  let view = [0, 33];

  renderRegionPage(region, 750, 400, bounds, view, regionGeoJSON);
})();