/* global define */
define(
  [
    'dojo/Deferred',
    'map/map_config',
    'widgets/StatisticsPane',
    'widgets/WidgetFactory',
    'cluster'
  ],
  function(
    Deferred,
    MapConfig,
    StatisticsPane,
    WidgetFactory,
    griddle
  ) {
    var o = {};

    o.create = function (map) {
      var tableResults;
      var searchFilter;
      var featureURL = MapConfig.features;
      var features = L.esri.Layers.featureLayer(featureURL, {});
      var countryURL = MapConfig.countries;
      var countries = L.esri.Layers.featureLayer(countryURL, {});
      var clusterLayer = new L.MarkerClusterGroup(
        {
          singleMarkerMode: true,
          showCoverageOnHover: false,
          maxClusterRadius: 50,
          spiderfyOnMaxZoom: false
        }
      );
      var popups = {
        'cluster': {
          obj: L.popup(),
          content: "<div id='{}'></div>",
          id: "clusterPopup"
        },
        'marker': {
          obj: L.popup(),
          content: "<div class='markerPopup' id='{}'></div>",
          id: "markerPopup",
          titleField: "org_name",
          displayFields: [
            { field: 'org_type', label: 'Organization Type' },
            { field: 'industry_id', label: 'Sector' },
            { field: 'org_hq_city', label: 'City' },
            { field: 'org_hq_country',label: 'Country' },
            { field: 'org_hq_country_region', label: 'Region' },
            { field: 'org_url', label: 'URL'},
            { field: 'org_description', label: 'Description'},
            { field: 'data_type', label: 'Type of data used'}
          ],
          idField: 'profile_id'
        }
      };

      clusterLayer.addTo(map);

      var control = {
        features: features,
        countries: countries,
        clusterLayer: clusterLayer,
        markers: [],
        statistics: []
      };

      var getClusterStats = function (markers, fieldName) {
        var attr = _.pluck(markers,'attributes').filter(function (o) {
          if (o[fieldName]) {
            return true;
          }
        });

        return _.countBy(attr,fieldName);
      };

      var getStatistics = function (markers) {
        return MapConfig.clusterStatFields.map(function (stat) {
          if (stat) {
            return { fieldName: stat, count: getClusterStats(markers, stat) };
          }
          else {
            return false;
          }
        }).filter(function (val) { return val; });
      };

      var openPopup = function (popupObj, latlng, renderComponent) {
        popupObj.obj.setLatLng(latlng)
          .setContent(popupObj.content.replace('{}', popupObj.id))
          .openOn(map);
        if (renderComponent) {
          new renderComponent.constructor(renderComponent.props, popupObj.id);
        }
      };

      var getCompanyPopupProps = function (marker, toggle, showContent) {
        var popupObj = popups.marker;

        marker.attributes
        var items = popupObj.displayFields
          .filter(function (attr) {
            return marker.attributes[attr.field];
          })
          .map(function (attr) {
            var item = {
              label: attr.label,
              value: marker.attributes[attr.field]
            }
            return item;
          });

        var title = {
          label: marker.attributes[popupObj.titleField],
          selected: showContent,
          toggle: toggle || false
        };

        return {
          items: items,
          title: title,
          showContent: showContent,
          profileID: { value: marker.attributes.profile_id }
        };
      };

      var getCompanyPopup = function (marker) {
        var html = "<div id='markerPopup'></div>"
        var popupObj = popups.marker;
        var props = getCompanyPopupProps(marker, false, true);
        openPopup(
          popupObj,marker.getLatLng(),
          { constructor: WidgetFactory.CompanyPopup, props:props }
        );
      };

      clusterLayer.on('clusterclick', function (a) {
        var markers = a.layer.getAllChildMarkers();
        var companies = markers.map(function (marker) {
          return getCompanyPopupProps(marker, true, false);
        })
        var popupObj = popups.cluster;
        var props = {companies:companies};

        if (map.getZoom() >= 3) {
          openPopup(
            popupObj,
            a.latlng,
            { constructor: WidgetFactory.ClusterPopup, props:props }
          );
        }
      });

      control.clearSearch = function () {
        document.getElementById("search-box").value = '';
        searchFilter = '';
      };

      control.selectCountries = function (where) {
        countries.setWhere(where)
      };

      control.setSearchFilter = function (filter) {
        searchFilter = filter;
        map.filterFeatures();
      };

      control.updateClusterLayer = function (featureCollection) {
        clusterLayer.clearLayers();
        control.markers = featureCollection.features.map(
          function (feature) {
            var geom = feature.geometry;
            var marker = new L.marker(
              [geom.coordinates[1], geom.coordinates[0]]
            );
            //org year requires additional formatting
            feature.properties.org_year_founded =
              feature.properties.org_year_founded ?
              parseInt(feature.properties.org_year_founded) : '';
            marker.attributes = feature.properties;
            marker.on('click',function (e) {
              getCompanyPopup(marker);
            });

            return marker;
          }
        );
        //filter just for adding cluster icons
        var profileIds = [];

        var filteredMarkers = _.filter(
          control.markers,
          function (marker) {
            if (_.contains(profileIds, marker.attributes.profile_id)) {
              return false;
            } else {
              profileIds.push(marker.attributes.profile_id);
              return true;
            }
          }
        );

        if (searchFilter) {
          // search filter for map view
          filteredMarkers = _.filter(
            filteredMarkers,
            function (marker) {
              if (marker.attributes.org_hq_country_region == null &&
                marker.attributes.dataCell == null) {
                if (
                  marker.attributes.org_name
                    .toLowerCase()
                    .indexOf(searchFilter.toLowerCase()) > -1 ||
                  marker.attributes.org_description
                    .toLowerCase()
                    .indexOf(searchFilter.toLowerCase()) > -1 ||
                  marker.attributes.industry_id
                    .toLowerCase()
                    .indexOf(searchFilter.toLowerCase()) > -1
                ) {
                  return true;
                } else {
                  return false;
                }
              } else if (marker.attributes.org_hq_country_region &&
                marker.attributes.dataCell == null) {
                if (
                  marker.attributes.org_hq_country_region
                    .toLowerCase()
                    .indexOf(searchFilter.toLowerCase()) > -1 ||
                  marker.attributes.org_name
                    .toLowerCase()
                    .indexOf(searchFilter.toLowerCase()) > -1 ||
                  marker.attributes.org_description
                    .toLowerCase()
                    .indexOf(searchFilter.toLowerCase()) > -1 ||
                  marker.attributes.industry_id
                    .toLowerCase()
                    .indexOf(searchFilter.toLowerCase()) > -1
                ) {
                  return true;
                } else {
                  return false;
                }
              } else {
                if (
                  marker.attributes.dataCell
                    .toLowerCase()
                    .indexOf(searchFilter.toLowerCase()) > -1 ||
                  marker.attributes.org_hq_country_region
                    .toLowerCase()
                    .indexOf(searchFilter.toLowerCase()) > -1 ||
                  marker.attributes.org_name
                    .toLowerCase()
                    .indexOf(searchFilter.toLowerCase()) >-1 ||
                  marker.attributes.org_description
                    .toLowerCase()
                    .indexOf(searchFilter.toLowerCase()) >-1 ||
                  marker.attributes.industry_id
                    .toLowerCase()
                    .indexOf(searchFilter.toLowerCase()) >-1
                ) {
                  return true;
                } else {
                  return false;
                }
              }
            }
          );

          // search filter for table view
          control.markers = _.filter(control.markers,
            function (marker) {
              if (marker.attributes.org_hq_country_region == null &&
                marker.attributes.dataCell == null) {
                if (
                  marker.attributes.org_name
                    .toLowerCase()
                    .indexOf(searchFilter.toLowerCase()) >-1 ||
                  marker.attributes.org_description
                    .toLowerCase()
                    .indexOf(searchFilter.toLowerCase()) >-1 ||
                  marker.attributes.industry_id
                    .toLowerCase()
                    .indexOf(searchFilter.toLowerCase()) >-1
                ) {
                  return true;
                } else {
                  return false;
                }
              } else if (marker.attributes.org_hq_country_region &&
                marker.attributes.dataCell == null) {
                if (
                  marker.attributes.org_hq_country_region
                    .toLowerCase()
                    .indexOf(searchFilter.toLowerCase()) > -1 ||
                  marker.attributes.org_name
                    .toLowerCase()
                    .indexOf(searchFilter.toLowerCase()) > -1 ||
                  marker.attributes.org_description
                    .toLowerCase()
                    .indexOf(searchFilter.toLowerCase()) > -1 ||
                  marker.attributes.industry_id
                    .toLowerCase()
                    .indexOf(searchFilter.toLowerCase()) > -1
                ) {
                  return true;
                } else {
                  return false;
                }
              } else {
                if (
                  marker.attributes.dataCell
                    .toLowerCase()
                    .indexOf(searchFilter.toLowerCase()) > -1 ||
                  marker.attributes.org_hq_country_region
                    .toLowerCase()
                    .indexOf(searchFilter.toLowerCase()) > -1 ||
                  marker.attributes.org_name
                    .toLowerCase()
                    .indexOf(searchFilter.toLowerCase()) > -1 ||
                  marker.attributes.org_description
                    .toLowerCase()
                    .indexOf(searchFilter.toLowerCase()) > -1 ||
                  marker.attributes.industry_id
                    .toLowerCase()
                    .indexOf(searchFilter.toLowerCase()) > -1
                ) {
                  return true;
                } else {
                  return false;
                }
              }
            }
          );
        }

        control.statistics = getStatistics(filteredMarkers);

        var attr = _.pluck(control.markers,'attributes');
        var totalCountries = _
          .keys(_.groupBy(attr,'org_hq_country_locode'))
          .length;

        map.updateStatistics(
          {
            stats: control.statistics,
            totalCases:filteredMarkers.length,
            totalCountries:totalCountries
          }
        );

        //apply search filters!
        clusterLayer.addLayers(filteredMarkers);
        control.updateTableData(control.markers);
      }

      control.getDataCellString = function (attributes) {
        var formedString = '';

        if (attributes.data_type) {
          formedString += attributes.data_type + ', ';
        }

        return formedString;
      }

      control.updateTableData = function (markers) {
        var profileIds = [];
        var tableMarkers = {};
        _.forEach(markers, function (marker) {
          if (_.contains(profileIds, marker.attributes.profile_id)) {
            //already in markers list
            // concat to marker already in tableMarkers
            tableMarkers[marker.attributes.profile_id].attributes.dataCell +=
              control.getDataCellString(marker.attributes);
          } else {
            // not in markers list
            // construct marker.dataCell and push into tableMarkers
            profileIds.push(marker.attributes.profile_id);
            marker.attributes.dataCell = control.getDataCellString(
              marker.attributes
            );
            tableMarkers[marker.attributes.profile_id] = marker;
          }
        })
        var concatMarkers = []
        _.forEach(tableMarkers, function (marker) {
          concatMarkers.push(marker);
        });
        tableResults = WidgetFactory.TableResults(concatMarkers, 'tableDiv');
      };

      control.exportTableData = function () {
        tableResults.exportTableData();
      };

      control.exportTableDataJSON = function () {
        tableResults.exportTableDataJSON();
      };

      return control;
    }

    return o;
  }
);