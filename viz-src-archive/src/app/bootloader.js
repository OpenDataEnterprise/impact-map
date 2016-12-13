(function(win, document) {
    'use strict';
    // This is the launcher bootloader function
    // Takes loades the config
    var launch = function(){
        // Build Page Based on Template
        win.dojoConfig = config;
        $(document).ready(function(){
            var setTemplate = $.get( './app/templates/app.html', function( data ) {
                $('body').html(data);
                $(document).foundation();
            });
        });
    };
    var basepath =location.pathname.replace(/\/[^/]+$/, '') + '/app',
    config = {
        parseOnLoad: false,
        isDebug: false,
        async: true,
        packages: [
            {
                name: "map",
                location: basepath + "/js/map"
            }, {
                name: "main",
                location: basepath + "/js/main"
            }, {
                name: "utils",
                location: basepath + "/js/utils"
            }, {
                name: "tools",
                location: basepath + "/js/tools"
            }, {
                name: "components",
                location: basepath + "/js/components"
            },{
                name: "widgets",
                location: basepath + "/widgets"
            },{
                name: "table",
                location: basepath + "/js/table"
            }
        ],
        aliases: [
            // Add Aliases to CDN Modules here like below
            ['react', 'app/includes/react/react2.js'],

            ['leaflet', 'app/includes/leaflet/leaflet.js'],
            ['esrileaflet','http://cdn-geoweb.s3.amazonaws.com/esri-leaflet/1.0.0-rc.5/esri-leaflet.js' ],
            ['cluster','app/includes/markercluster/js/leaflet.markercluster-src.js'],

        ],
        deps: [
            "dojo/domReady!"
        ],
        callback: function () {
            loadScript('app/js/loader.js');
        }
    };

    //TODO change require config if replacing require with dojo amd loader
    // requirejs.config({
    // baseUrl: 'app',
    // paths: {
    //         map: '/js/map',
    //         main: '/js/main',
    //         utils: '/js/utils',
    //         tools: '/js/tools',
    //         components: '/js/components',
    //         widgets: '/js/widgets',
    //         knockout: 'http://cdnjs.cloudflare.com/ajax/libs/knockout/3.1.0'
    //     }
    // });
    // end TODO

    var loadScript = function(path){
        var script = document.createElement( 'script' );
        script.type = 'text/javascript';
        script.src = path;
        $("head").append( script );
    };



    win.onload = launch();
    


})(window, document);