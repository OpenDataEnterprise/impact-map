import { renderRegionPage } from 'renderRegionPage';
import { regionGeoJSON } from 'geojson/geojson-ecs.js';

(function () {
  let region = 'Europe & Central Asia';

  // Coordinates defining bounds of map draggability.
  let lowerBound = [20, -90];
  let upperBound = [90, 180];
  let bounds = [lowerBound, upperBound];

  // Coordinate for default viewpoint.
  let view = [45, 30];

  renderRegionPage(region, 1160, 400, bounds, view, regionGeoJSON);
})();