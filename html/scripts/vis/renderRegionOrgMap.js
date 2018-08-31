import L from 'leaflet';

// get color depending on population density value
function getColor (d) {
  return d > 100 ? '#c55441' :
    d > 10 ? '#d6877a' :
    d > 0 ? '#e7bab3' : '#b8bdbe';
}

function style (feature) {
  return {
    weight: 1,
    opacity: 1.0,
    color: '#2b3d51',
    dashArray: '',
    fillOpacity: 1.0,
    fillColor: getColor(feature.properties.ORGS)
  };
}

function highlightFeature (e, geoLayer, mapLayer, info) {
  console.log('Highlighting feature');
  mapLayer.bringToFront();

  let layer = e.target;
  info.update(layer.feature.properties);

  geoLayer.setStyle({
    weight: 1,
    opacity: 0.3,
    fillOpacity: 0.3
  });

  layer.setStyle({
    weight: 1,
    opacity: 1.0,
    color: '#2b3d51',
    dashArray: '',
    fillOpacity: 1.0,
    fillColor: '#375F79'
  });

  if (!L.Browser.ie && !L.Browser.opera) {
    layer.bringToFront();
  }

  mapLayer.setOpacity(0.2);
}

function resetHighlight (e, geoLayer, mapLayer, info) {
  info.update();

  geoLayer.resetStyle(e.target);

  geoLayer.setStyle({
    weight: 1,
    opacity: 1.0,
    fillOpacity: 1.0
  });

  mapLayer.setOpacity(1.0);
}

export function renderRegionOrgMap (region, geojson, bounds, view, config) {
  let apiBaseURL = config.apiBaseURL;
  let encodedRegion = encodeURIComponent(region);

  let mapQueryURL = apiBaseURL + 'region/' + encodedRegion +
    '/country-organization-count';
  $.getJSON(mapQueryURL, function (data) {
    let map = L.map('map',
      {
        zoomControl: true,
        maxZoom: 6,
        minZoom: 2,
        maxBounds: bounds
      }
    ).setView(view, 2);

    let mapLayer = L.tileLayer(
      'http://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}.png',
      {
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
        '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
        'Imagery © <a href="http://mapbox.com">Mapbox</a>',
        id: 'mapbox.street'
      }
    );

    mapLayer.addTo(map);

    //control that shows state info on hover
    let info = L.control({ position: 'topright' });

    info.onAdd = function (map) {
      this._div = L.DomUtil.create('div', 'info');
      this.update();
      return this._div;
    };

    info.update = function (props) {
    this._div.innerHTML = (props ?
      '<b>' + props.NAME + '</b><br />' + props.ORGS + ' Organizations'
      : '<b>Number of Organizations</b><br> Hover over a country');
    };

    info.addTo(map);

    mapLayer.setOpacity(1.0);

    let numCountries = data.length;
    let d = data;

    for (let i = 0; i < geojson.features.length; i++) {
      for (let j = 0; j < numCountries; j++) {
        d[j]['alpha2'] = d[j]['alpha2'].trim();

        if (geojson.features[i].properties.ISO2 == d[j]['alpha2']) {
          geojson.features[i].properties.NAME = d[j]['country'];
          geojson.features[i].properties.ORGS = d[j]['organization_count'];

          break;
        }
      }

      // Ensure no countries have an undefined number of organizations.
      if (typeof geojson.features[i].properties.ORGS === 'undefined') {
        geojson.features[i].properties.ORGS = 0;
      }
    }

    let geoLayer = L.geoJson(geojson, {
      style: style,
      onEachFeature: function (feature, layer) {
        layer.on({
          mouseover: function (e) {
            highlightFeature(e, geoLayer, mapLayer, info);
          },
          mouseout: function (e) {
            resetHighlight(e, geoLayer, mapLayer, info);
          }
        });
      },
    }).addTo(map);

    // Add color legend to map.
    let legend = L.control({position: 'bottomright'});

    legend.onAdd = function (map) {
      let div = L.DomUtil.create('div', 'info legend');
      let labels = [];

      labels.push(
        '<i style="background:' + '#e7bab3' + '"></i> ' +
        1 + '&ndash;' + 10);

      labels.push(
        '<i style="background:' + '#c55441' + '"></i> ' +
        11 + '&ndash;' + 100);

      labels.push(
        '<i style="background:' + '#c51c00' + '"></i> ' +
        100 + '+');

      div.innerHTML = labels.join('<br>');
      return div;
    };

    legend.addTo(map);
  });
}