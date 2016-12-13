/**
 * Created by jnordling on 12/13/14.
 */
define([/*"esri/map",*/
    "map/map_config",
    "map/LayerControl",
    'main/fetcher',
    'widgets/StatisticsPane',
    'widgets/LeftPanel'


],function(
    MapConfig,
    LayerControl,
    fetcher,
    StatisticsPane,
    LeftPanel
){
    'use strict';
    var brmap,basemap,filterValues, zoomHome;
    var control = {};
    var metaPropsForLeftPanel;


    var getFieldNameLabel = function(fieldName){
        var label = false;
        var fields = MapConfig.filters.forEach(function(filter){
            if (filter.source.field === fieldName){
                label = filter.label;
            }
        });
        return label;
    }

    var updateStatistics = function(statistics){
        statistics.filters = [];
        var filterCategoryLabels = control.getFiltersLabels();
        _.forEach(filterCategoryLabels, function(filterList){
            _.forEach(filterList, function(filter){
                statistics.filters.push({label: filter});
            })
        })
        if(document.getElementById('filterStats')){
            new StatisticsPane(statistics,'filterStats');
        } else {
            setTimeout(function(){StatisticsPane(statistics,'filterStats')}, 1000); //hack for race condition
        }

    }
    var mapEventHandlers = function(){
        var filterFeatures = function(){
            console.log('filter clusters')
            control.filterFeatures(control.getFilters());
        }
        brmap.filterFeatures = function(){
            console.log('filter clusters')
            control.filterFeatures(control.getFilters());
        }
        brmap.on('zoomend', filterFeatures);
        brmap.on('dragend', filterFeatures);
        brmap.on('zoomstart', control.closePopups);

        //brmap.on('click', control.queryForCountryCode)

    }

    control.closePopups = function(){
        brmap.closePopup();
    }

    control.setMetaProps = function(props){
        metaPropsForLeftPanel = props;
    }

    control.queryForCountryCode = function(evt){

        var query = new L.esri.Tasks.Query({url:MapConfig.tempCountryURL});
        query.contains(evt.latlng)
            .returnGeometry(true)
            .run(function(error, featureCollection, response){

                    if(featureCollection.features[0]) {
                        var iso2 = featureCollection.features[0].properties.ISO2;
                        _.forEach(metaPropsForLeftPanel.accordian.items, function(item){
                            if(item.label==="Country"){
                                _.forEach(item.items, function(country){
                                    if(country.value == iso2){
                                        country.selected = true;
                                    } else {
                                        country.selected = false;
                                    }
                                })
                            }
                        })

                        var leftPanel = new LeftPanel(metaPropsForLeftPanel, "leftPanel");
                    }

            });
    }

    control.getFiltersLabels = function(){
        return filterValues.labels;
    }

    control.getFilters = function(){
        var filters = _.keys(filterValues).map(function(key){
            if (filterValues[key].length ){
                var values = ['(', filterValues[key].join(','), ')'].join('');
                return {'fieldName':key,'value': values, 'operator': 'in'};
            }
        });

        return filters.filter(function(o) { return o; });
    }

    control.clearFilter = function(){
        _.keys(filterValues).forEach(function(key){
            if(key == 'labels'){
                _.keys(filterValues[key]).forEach(function(deepKey){
                    filterValues[key][deepKey] = [];
                })
            } else {
                filterValues[key] = [];
            }
        })
        control.filterFeatures(false);

        brmap.layerControl.clearSearch();

        //rest home!
        zoomHome._zoomHome();

    }

    control.updateFilter= function(values,fieldName,updateFeatures, labels){
        /* Temporary fix by Myeong to allow multiple values per item */
        if (fieldName == "org_year_founded"){
            _.forEach(values, function(v){
                filterValues[fieldName] = v.map(function(value){
                    return "'{}'".replace('{}',value);
                });
            });
        } else {
            filterValues[fieldName] = values.map(function(value){
                return "'{}'".replace('{}',value);
            });
        }        
        
        filterValues.labels[fieldName] = labels;
        
        if (updateFeatures){
            this.filterFeatures(this.getFilters());
        }
        return filterValues;
    }

    control.filterFeatures = function(filters){        
        var where;
        if(filters){
            where = fetcher.getQueryString(filters);
        } else {
            where = "1=1";
        }
        var bounds = brmap.getBounds();
        L.esri.Tasks.query({url:MapConfig.features})
                    .where(where)
                    .within(bounds)
                    .run(function(error, featureCollection, response){
                        brmap.layerControl.updateClusterLayer(featureCollection);
                    });
        // L.layerControl.features.where
    }

    control.selectCountries = function(values,fieldName){

        var where = fieldName + ' in ' + ["('", values.join("','"), "')"].join('');
        if (!values.length){
            where = "1=1";
        }
        brmap.layerControl.selectCountries(where);
    }

    control.mapResize = function(){
        brmap.invalidateSize();
    }
    control.changeBaseMap = function(obj){
        brmap.remove(basemap);
        basemap = L.esri.basemapLayer(obj.target.id).addTo(brmap);
        // brmap.setBasemap(obj.target.id);
    }
    control.getMap = function(){
        return brmap;
    }


    control.init = function(mapDiv){

        var lat = 20.89009754221236;
        var lng = 30.03990936279297;
        var zoom = 2;

        brmap = new L.Map(mapDiv, {zoomControl:false, maxZoom: 10, minZoom: 2})
                    .setView([lat, lng], zoom);
        
        basemap = L.esri.basemapLayer("Topographic").addTo(brmap);
        L.control.scale().addTo(brmap);
        brmap.layerControl = LayerControl.create(brmap);

        filterValues= {};
        filterValues.labels = {};
        _.pluck(MapConfig.filters,'source').forEach(function(source){
            if (source){
                filterValues[source.field] = [];
                filterValues.labels[source.field] = [];
            }
        });

        brmap.updateStatistics = updateStatistics;
        mapEventHandlers();

        L.Control.zoomHome = L.Control.extend({
            options: {
                position: 'topright',
                zoomInText: '+',
                zoomInTitle: 'Zoom in',
                zoomOutText: '-',
                zoomOutTitle: 'Zoom out',
                zoomHomeText: '<i class="fa fa-home" style="line-height:1.65;"></i>',
                zoomHomeTitle: 'Zoom home'
            },

            onAdd: function (map) {
                var controlName = 'gin-control-zoom',
                    container = L.DomUtil.create('div', controlName + ' leaflet-bar'),
                    options = this.options;

                this._zoomInButton = this._createButton(options.zoomInText, options.zoomInTitle,
                    controlName + '-in', container, this._zoomIn);
                this._zoomHomeButton = this._createButton(options.zoomHomeText, options.zoomHomeTitle,
                    controlName + '-home', container, this._zoomHome);
                this._zoomOutButton = this._createButton(options.zoomOutText, options.zoomOutTitle,
                    controlName + '-out', container, this._zoomOut);

                this._updateDisabled();
                brmap.on('zoomend zoomlevelschange', this._updateDisabled, this);

                return container;
            },

            onRemove: function (map) {
                brmap.off('zoomend zoomlevelschange', this._updateDisabled, this);
            },

            _zoomIn: function (e) {
                this._map.zoomIn(e.shiftKey ? 3 : 1);
            },

            _zoomOut: function (e) {
                this._map.zoomOut(e.shiftKey ? 3 : 1);
            },

            _zoomHome: function (e) {
                brmap.setView([lat, lng], zoom);
            },

            _createButton: function (html, title, className, container, fn) {
                var link = L.DomUtil.create('a', className, container);
                link.innerHTML = html;
                link.href = '#';
                link.title = title;

                L.DomEvent.on(link, 'mousedown dblclick', L.DomEvent.stopPropagation)
                    .on(link, 'click', L.DomEvent.stop)
                    .on(link, 'click', fn, this)
                    .on(link, 'click', this._refocusOnMap, this);

                return link;
            },

            _updateDisabled: function () {
                var map = this._map,
                    className = 'leaflet-disabled';

                L.DomUtil.removeClass(this._zoomInButton, className);
                L.DomUtil.removeClass(this._zoomOutButton, className);

                if (map._zoom === map.getMinZoom()) {
                    L.DomUtil.addClass(this._zoomOutButton, className);
                }
                if (map._zoom === map.getMaxZoom()) {
                    L.DomUtil.addClass(this._zoomInButton, className);
                }
            }
        });
           // add the new control to the map
        zoomHome = new L.Control.zoomHome();
        zoomHome.addTo(brmap);


    }



    return control;
});


