#Map Developer Document  
This document explains how we can edit each and every feature in the map and explains the important pieces of code in particular files. The map has been built using React.js

##Explanation according to individual files

**Map.html**
* This files contains body tag with class “br” where the map loads. 
* This body starts from the top of the navigation bar to the end of the map. 
* Map.html is NOT obtained from webflow like other files and is independent of the webflow HTML files.

**app/css**
* This folder contains the app.css file which controls all the css styling of the map.
* The .styl files in the folder are no longer used.

**app/images**
* This folder contains all the images required for the map

**app/includes**
* This folder contains all javascript files that are required to run the map

**app/bootloader.js**
* The map.html file loads the bootloader.js file in the header.
* This file loads the app.html file which creates the tags and contents inside the body “br” class of the map.
* It also loads other relevant js files and then loads the app/js/loader.js file.

**app/js/loader.js**
* This file loads the init() function from the app/js/main/Main.js file. 
* This function starts the process of building the components of the map.

**app/js/components**
* Not used

**app/js/main**
* Config.js - This file is used to specify the map layers and map panels ie Map View and Data View.
* Main.js - This file is used to launch the left panel with the filters etc and the center panel with the map and table view.
* Events.js - This file contains functions that responds to certain events in the map
* Fetcher.js - This file is used for querying to the ArcGIS database.
* View.js - This file controls the view of the map and initializes the left panel and the center panel containing the map.

**app/js/map**
* LayerControl.js - This file is used to control the bubbles (markers) on the map and the corresponding popups that are visible when clicked
* Map_config.js - This file is used to connect to the ArcGIS database and to specify the fields that are to be used as filters in the left panel. 
* MapController. Js - This file loads the map in the map view to the desired latitude and longitude, zoom level and basemap layer. It also controls the way the map behaves when a filter is selected or cleared.

**app/js/table**
* TableController.js - This file was used in the app/js/widgets/tableResults.js to load the table in the data view. Not used anymore.

**app/templates**
* App.html - This html loads the the navigation bar and the tags in the map which are then dynamically filled by components using React.js in other javascript files
* The .jade files in this folder are not used anymore

**app/widgets**
* The files in the jsx folder are not used anymore
* Accordion.js - This file is used to create the accordion elements in the LeftPanel.js file. Accordian elements are the filters like “Country”, “Type of data used” and its subsequent items.
* baseMapGallery.js - This file contains controls regarding the basemap.Not used anymore 
* baseMapItem.js - It is used to create an basemap entry in the basemap gallery. Not used anymore.
* CenterPanel.js - This file is used to load the center area which includes the Map View and the Data View.
* Checkbox.js - This file is used to create the checkbox in the accordion items.
* ClusterPopup.js - This file is used to create the popup that is visible when click on a bubble with more than one number of organization
* CompanyPopup.js - This file is used to create the popup that is visible when clicked on a bubble with 1 in the organization number
* LeftPanel.js - This file is used to create all the elements of the left panel i.e. the search bar, the four filters, clear filter button, Download data in CSV and Download Data in JSON button.
* Radiogroup.js - This file is used the create the Selectable group class which is used in LeftPanel.js while creating the accordians. Not used anymore.
* renderTo.js - This file is used to render a particular element and a corresponding component
* SelectableGroup.js - This file is used the create the Selectable group class which is used in LeftPanel.js while creating the accordians.
* SelectableItem.js - This file is used the create the SelectableItem group class which is used SelectableGroup used in LeftPanel.js while creating the accordians.
* StatisticsPane.js - This file is used to create the  Statistics pane. Not used anymore.
* Switch.js - Not used anymore
* tableResults.js - This file is used to create a the table to display in the table view. It also creates the data that is downloaded when clicked in the “Download CSV data” and “Download JSON data” buttons
* ToggleGroup.js - No longer used.
* WidgetFactory.js - Used to render popups and table. Used in LayerControl.js.

##Explanation according to features

1. Adding/Removing the Left Panel filters
   * Make changes to the map_config file. Add/remove the filter in the filters: [ …] object of the return statement.
   * To manipulate labels and display of the filters, make changes to LeftPanel.js and SelectableItem.js (called by LeftPanel.js)

2. Adding/Removing items from the left panel
   * Make changes to the return of LeftPanel.js
   * Clear Filters - function in leftpanel.js
   * Download CSV and JSON data buttons - Search “props.exportTableData” in LeftPanel.js and all the documents and follow the track from where it gets called originally.

3. Making changes to the Map
   * Zoom control, bounds, baselayer - This can be changed in the MapController.js
   * To edit the popups - Make changes to CompanyPopup.js and CusterPopup.js
   * To change the color and size of the bubbles - Make changes to app>includes>markercluster>css>MarkerCluster.Default.js

4. Making Changes to the Map View and Data View buttons
   * To edit the labels for the Map and Data view, make changes to the map-config.js code.
   * Make changes to WIdgetFactory.js to set the default view.

5. Making changes to Data View
   * The table is created in the return of TableResults.js
   * Make changes to the same file to manipulate 
   * Make changes to griddle.js for customizing the table look and feel
	
6. Styling the webpage
   * To make any styling or css changes to the map page, make changes in the app.css file.

