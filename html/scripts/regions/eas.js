import { renderRegionPage } from 'renderRegionPage';
import { regionGeoJSON } from 'geojson/geojson-eas.js';

(function () {
  let region = 'East Asia & Pacific';

  // Coordinates defining bounds of map draggability.
  let lowerBound = [-60, 60];
  let upperBound = [60, 200];
  let bounds = [lowerBound, upperBound];

  // Coordinate for default viewpoint.
  let view = [4, 143];

  renderRegionPage(region, 1160, 400, bounds, view, regionGeoJSON);
})();