import { renderRegionPage } from 'renderRegionPage';
import { regionGeoJSON } from 'geojson/geojson-mea.js';

(function () {
  let region = 'Middle East & North Africa';

  // Coordinates defining bounds of map draggability.
  let lowerBound = [8, -23];
  let upperBound = [43, 70];
  let bounds = [lowerBound, upperBound];

  // Coordinate for default viewpoint.
  let view = [26, 24];

  renderRegionPage(region, 470, 400, bounds, view, regionGeoJSON);
})();