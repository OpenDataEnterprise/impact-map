define([
    'map/MapController',
    'map/map_config',
    'main/config',
    'main/Events',
    'main/fetcher',
    'widgets/baseMapGallery',
    'widgets/switch',
    'widgets/SelectableGroup',
    'widgets/ToggleableGroup',
    'widgets/LeftPanel',
    'widgets/CenterPanel',

    'widgets/StatisticsPane',
    'dojo/Deferred',
    "dojo/promise/all",
    "leaflet",
    "esrileaflet"
], 
    
function(
        MapController,
        MapConfig,
        MainConfig,
        Events,
        Fetcher,
        BaseMapGallery, 
        Switch,
        SelectableGroup,
        ToggleableGroup,
        LeftPanel,
        CenterPanel,
        StatisticsPane,
        Deferred,
        All
) {
 	var control = {};
 	

 	var get_service_info = function(){
            // Fetcher.features(MapConfig.features,{'where':"1=1"}).then(function(results){
            // });

            Fetcher.uniqueFields(MapConfig.features,'org_type').then(function(results){

            });

    }

	// var build_radio_group =  function(items,div,callback){
 //            var radioGroup = new ToggleableGroup(
 //                    {
 //                        id:'layer-radios',
 //                        idPrefix: 'radio',
 //                        uiClass: 'br-radio',
 //                        items:items,
 //                        changed: callback
 //                        // changed: selectCallback
 //                    },
 //                div
 //            )
 //    }

    var build_radio_group =  function(items,div,callback){
                 return  ({
                        classNames: ['layer-radios','br-radio'],
                        items:items,
                        changed: callback
                    })
    }

    var build_map_area_ui =  function(){
        var mapTabs = new SelectableGroup({
            id: 'map-panel-group',
            uiClass: 'br-panel-group',
            outerContent: true,
            idPrefix: 'mapPanelGroup',
            items: MainConfig.map_panels,
            // changed: selectCallback
    	}, "mapArea")
    }

    control.renderStatisticsPane = function(props){
        new StatisticsPane(props,'filterStats');
    }


    var initLeftPanelComponent = function(){
    	var props = {id:'leftPanelComponent'}

    	props.tabs = {
            id: 'tab-items',
            uiClass: 'br-tab-items',
            outerContent: true,
            idPrefix: 'tabItem',
            items: MainConfig.panels,
            changed: Events.selectPanelGroup,
        }

        props.selectFilter = Events.updateFilter;

        props.exportTableData = Events.exportTableData;

        props.exportTableDataJSON = Events.exportTableDataJSON;

        props.closePopups = Events.closePopups;

        props.setSearchFilter = Events.setSearchFilter;

        props.exportMap = Events.exportMap;

        props.statisticsDiv = "filterStats";

        props.accordian = {
            // id: 'filter-group',
            // innerContent: true,
            // classNames: ['filter-group','br-accordian'],
            // idPrefix: 'filter',
            items: MapConfig.filters,
            changed: Events.selectFilterGroup,
            selected: false
        }

       var deferreds = MapConfig.filters.map(function(filter){
        	var deferred = new Deferred();
        	filter.classNames = ['filter-label'];

            if (filter.source){
            	filter.items = [];
                
                var groupBy = filter.source.groupBy || [filter.source.field];
                var labelField = filter.source.labelField || filter.source.field;
                var valueField = filter.source.valueField || filter.source.field;
                var targetField = filter.source.targetField || filter.source.field;


                Fetcher.uniqueFields(filter.source.url,valueField,"1=1",groupBy).then(function(fields){

                    if(valueField!= targetField){
                        Fetcher.uniqueFields(MapConfig.features,filter.source.field,"1=1",[filter.source.field]).then(function(ISOs){


                            var isoList = _.pluck(ISOs, 'org_hq_country_locode');
                            fields = _.filter(fields, function(item){
                                if(!item[valueField]){return false};
                                if(_.contains(isoList, item[valueField])){
                                    return true;
                                } else {
                                    return false;
                                }
                            })
                            filter.items = control.getFilterItems(valueField, labelField, targetField, fields)
                            filter.items = _.sortBy(filter.items, 'label');
                            deferred.resolve(true);
                        });
                    } else {
                        filter.items = control.getFilterItems(valueField, labelField, targetField, fields);                        
                        deferred.resolve(true);
                    }

                    filter.items = _.sortBy(filter.items, 'label');

                    //control.getFilterItems = function(valueField, labelField, targetField, fields){

					// React.render();                    

                    // build_radio_group(filter.items, "filter" + filter.value,Events.updateFilter);
                });
            }
            else{
            	filter.items.forEach(function(item){
            		item.changed = Events.updateFilter;
            		item.toggle = true;
            		item.classNames = ['layer-radios','br-radio'];
            	});
            	deferred.resolve(true);
            }
            return deferred;
        });



    	All(deferreds).then(function(results){
            props.clearFilter = Events.clearFilter;
            MapController.setMetaProps(props);
    		var leftPanel = new LeftPanel(props,"leftPanel");
    	});

    }

    control.getFilterItems = function(valueField, labelField, targetField, fields){

        fields = _.filter(fields, function(field){
            if(!!field[labelField]){
                return true
            } else {
                return false
            }
        })

        return fields.map(function(field) {

            //if(field.iso is in iso list return

            return {
                selected: false,
                value: field[valueField],
                label: field[labelField],
                fieldName: targetField,
                classNames: ['layer-radios', 'br-radio'],
                toggle: true
            }

            //else return false;
        });
    }

    control.initCenterPanelComponent = function(){
        var props = {
            mapId:'mapDiv',
            tableId:'tableDiv'
        }
        
        props.tabs = {
            id: 'tab-items',
            uiClass: 'br-tab-items',
            outerContent: true,
            idPrefix: 'tabItem',
            items: MapConfig.panels,
            changed: Events.selectPanelGroup
        }
        var centerPanel = new CenterPanel(props,"centerPanel");

    }

    control.init = function(){
 			// build_panel_ui();
 			initLeftPanelComponent();
            // initCenterPanelComponent();
            // this.get_service_info();
 	} 
 	return control;
});