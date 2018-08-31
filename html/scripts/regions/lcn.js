import { renderRegionPage } from 'renderRegionPage';
import { regionGeoJSON } from 'geojson/geojson-lcn.js';

(function () {
  let region = 'Latin America & Caribbean';

  // Coordinates defining bounds of map draggability.
  let lowerBound = [-65, -135];
  let upperBound = [40, -25];
  let bounds = [lowerBound, upperBound];

  // Coordinate for default viewpoint.
  let view = [-22, -60];

  renderRegionPage(region, 1160, 400, bounds, view, regionGeoJSON);
})();