/**
 * Created by jnordling on 12/13/14.
 */
/* global define */
define([
    'map/MapController',
    'table/TableController',
    'map/map_config',
    'main/config',
    'main/Events',
    'main/fetcher',
    'main/View',

    'widgets/baseMapGallery',
    'widgets/switch',
    'widgets/SelectableGroup',
    'widgets/ToggleableGroup',
    'widgets/LeftPanel',
    "leaflet",
    "esrileaflet"
    ], 
    
    function(
        MapController,
        TableController,
        MapConfig,
        MainConfig,
        Events,
        Fetcher,
        View,
        BaseMapGallery, 
        Switch,
        SelectableGroup,
        ToggleableGroup,
        LeftPanel
    ) {

    var self;
    return {
        init: function(){
            // We can load a Lost of stuff here
            //this.buil_panel_control();
            // Creating scope varable for reference
            this.launchMap();
            this.launchTable();
            self = this
        },
        launchMap: function(){
            //this.buildLeftPannel();
            View.init();
            View.initCenterPanelComponent();

            this.set_LeftPannelToggle();
            this.set_WindowResize();
            this.set_right_menu_toggle();
            // this.build_map_area_ui();
            MapController.init('mapDiv');
            MapController.filterFeatures([]);
        },

        launchTable: function(){

        },

        set_LeftPannelToggle: function(){
            $('#PanelToggle').click(function(){
                $('#PanelToggle').css('display','none');
                var pannel = $('#leftPanel');
                if (MainConfig.pannel_state ==true){
                    w = 0;
                    $('#PanelToggle').css('left','0');
                    MainConfig.pannel_state = false;
                }else{
                    w = 350
                    $('#PanelToggle').css('left','350px');
                    MainConfig.pannel_state = true;
                }
                pannel.animate({
                    width: w,
                  }, 250, function() {
                    MapController.mapResize();
                    $('#PanelToggle').css('display','');
                  });
            });
        },

        

        set_right_menu_toggle:function(){
            $('.item').click(function(){
                var item = $( ".item" );
                var fillPannel = $('#fillPannel')
                var menu_item = $('#'+this.id);
                if(menu_item.hasClass('active')){
                    item.removeClass( "active" );
                    fillPannel.hide( "fast",function(){
                        //hide complete
                    });
                }else{
                    self.build_menu_item(this.id);
                    item.removeClass( "active" );
                    menu_item.addClass('active');
                    fillPannel.show( "fast",function(){
                        //show complete
                    });
                }
            });

        },


        build_menu_item:function(id){

            if(id =="basemap"){
                var basemap = new BaseMapGallery({id:'baseMapGallery'},"rightNavContent");
                //console.log(basemap.);
            }else{
                $('#rightNavContent').html("");
            }

        },

        set_WindowResize:function(){
            $( window ).resize(function() {
                MapController.mapResize();
            });
        }
    }
});