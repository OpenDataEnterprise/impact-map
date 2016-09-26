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

        //console.log("inside initLeftPanelComponent");//Vinayak

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

        //Added by Vinayak for adding Machine Readability Layer 07.28.16
        props.addLayer = Events.addLayer;

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

        //Added for csv json Vinayak
        props.accordian2 = {
            items: MapConfig.download,
            //changed: Events.selectFilterGroup,
            selected: false
        }
        
            //console.log("I am after props.accordian" ,props.accordian); //Vinayak
                //console.log(JSON.parse(JSON.stringify(props)));


       var deferreds = MapConfig.filters.map(function(filter){
        	var deferred = new Deferred();
        	filter.classNames = ['filter-label'];

            if (filter.source){
            	filter.items = [];
                
                var groupBy = filter.source.groupBy || [filter.source.field];
                var labelField = filter.source.labelField || filter.source.field;
                var valueField = filter.source.valueField || filter.source.field;
                var targetField = filter.source.targetField || filter.source.field;

                //console.log(groupBy); //Vinayak
                //console.log(labelField);//Vinayak
                //console.log(valueField);//Vinayak
                //console.log(targetField);//Vinayak
                //console.log(filter.source.url);//Vinayak

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

                        //console.log(filter.items); //Vinayak

                        deferred.resolve(true);
                    }

                    filter.items = _.sortBy(filter.items, 'label');

                    //console.log("These are filter.items", filter.items); //Vinayak

                    //control.getFilterItems = function(valueField, labelField, targetField, fields){

					// React.render();                    

                    // build_radio_group(filter.items, "filter" + filter.value,Events.updateFilter);
                }); //then ends
            }
            else{
            	filter.items.forEach(function(item){
            		item.changed = Events.updateFilter;
            		item.toggle = true;
            		item.classNames = ['layer-radios','br-radio'];
            	});
            	deferred.resolve(true);
            }

           //console.log("This is defferefd", deferred); //Vinayak
            return deferred;
        });

       // console.log("This is props", props.accordian); //Vinayak

    	All(deferreds).then(function(results){
           
            props.clearFilter = Events.clearFilter;

            MapController.setMetaProps(props);

            //console.log("This is props after deffered", props); //Vinayak
    		var leftPanel = new LeftPanel(props,"leftPanel");
    	});

    }

    control.getFilterItems = function(valueField, labelField, targetField, fields){

        fields = _.filter(fields, function(field){

            //console.log(field[labelField]); //Vinayak
            //console.log(!!field[labelField]); //Vinayak

            if(!!field[labelField]){
              //  console.log("I am in true"); //Vinayak
                return true
            } else {
                //console.log("------------------------I am in false--------------------"); //Vinayak
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