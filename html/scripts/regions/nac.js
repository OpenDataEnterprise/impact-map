import { renderRegionPage } from 'renderRegionPage';

(function () {
  let region = 'North America';

  // Coordinates defining bounds of map draggability.
  let lowerBound = [15, -185];
  let upperBound = [84, -50];
  let bounds = [lowerBound, upperBound];

  // Coordinate for default viewpoint.
  let view = [55, -105];

  renderRegionPage(region, 1160, 400, bounds, view, regionGeoJSON);
})();