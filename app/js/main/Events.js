/**
 * Created by jnordling on 12/13/14.
 */
define([/*"esri/map",*/
    "map/map_config",
    "map/MapController"

],function(
    MapConfig,
    MapController
){
    'use strict';
    var brmap,basemap;
    var exports = {}

    exports.updateFilter = function(selectedItems,fieldName){
        var values = _.pluck(selectedItems,'value');
        var labels = _.pluck(selectedItems,'label');
        MapController.updateFilter(values,fieldName,true, labels);
        if (fieldName===MapConfig.countryFields.target){
            MapController.selectCountries(values,MapConfig.countryFields.source);
        }
        return;
    }

    exports.clearFilter = function(){
        MapController.clearFilter();
    }

    exports.selectFilterGroup = function(group){
        console.log('selectFilterGroup',group);

        return;
    }

    exports.exportMap = function(){

        //document.getElementById('mapDiv')
        html2canvas(document.body, {
            "logging": true, //Enable log (use Web Console for get Errors and Warnings),
            "allowTaint":false,
            //"proxy":"app/proxy/html2canvasproxy.php",
            "useCORS": true,
            "onrendered": function(canvas) {

                //$('body').empty();

                //var img = new Image();
                ////img.onload = function() {
                ////    img.onload = null;
                ////    document.body.appendChild(img);
                ////};
                //img.onerror = function() {
                //    img.onerror = null;
                //    if(window.console.log) {
                //        window.console.log("Not loaded image from canvas.toDataURL");
                //    } else {
                //        alert("Not loaded image from canvas.toDataURL");
                //    }
                //};
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1; //January is 0!

                var yyyy = today.getFullYear();
                if(dd<10){
                    dd='0'+dd
                }
                if(mm<10){
                    mm='0'+mm
                }
                var today = dd+'_'+mm+'_'+yyyy;

                canvas.toBlob(function(blob){
                    fileSaveAs(blob, "Open Data Enterprise Map _ " + today + '.jpg');
                });

            }
        });


        //var baseURL = window.location.pathname
		//
        //$("#mapDiv").printThis(
		//
        //    {importStyle: true}
        //    //{
        //    //debug: false,
			////
        //    //importStyle: true,
        //    //printContainer: false,
        //    //removeInline: false,
        //    //printDelay: 333,
        //    //header: null,
        //    //formValues: true
        ////}
        //);
    }

    exports.setSearchFilter = function(filter){
        console.log("In events setSearchFilter"); //Vinayak
        MapController.getMap().layerControl.setSearchFilter(filter);
    }

    exports.exportTableData = function(){
        MapController.getMap().layerControl.exportTableData();
    }

    exports.exportTableDataJSON = function(){
        MapController.getMap().layerControl.exportTableDataJSON();
    }

    exports.selectPanelGroup = function(group){
        console.log('selectPanelGroup',group);
        return;
    }

    exports.fireHome = function(){
        MapController.fireHome();
    }

    exports.updateStatistics = function(statistics){
        //Commented by Vinayak 07.13.16 to Remove Statistics
        // View.renderStatisticsPane(statistics);
    }

    exports.closePopups = function(){
        MapController.getMap().closePopup();
    }

    //Added by Vinayak for adding Machine Readability Layer 07.28.16
    exports.addLayer = function(){
        console.log('inside exports.addLayer ');
        MapController.addMaclayer();
    }

    return(exports);
});


