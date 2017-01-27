* For every individual region map, we have a separate php files (code for map) and .js files (GeoJSON data) stored in /js-custom folder. 

* The dbconnect.php file is common to all the individual map

* The following are the files for individual map viz – 
#### Leaflet code
- EastAsiaMap.php
- EuropeMap.php       
- LatinAmericaMap.php 
- MidEastMap.php  
- NorthAmericaMap.php 
- SouthAsiaMap.php    
- SubSaharanMap.php


#### GeoJSON code
- EastAsia.js
- EuropeCentralAsia.js    
- LatinAmericaCarr.js
- MidEast.js  
- NorthAmerica.js 
- SouthAsia.js    
- SubSaharanAfrica.js 

#### Common to above
- dbconnect.php

### dbconnect.php
- This file is used to get the data from the MySQL database.
- $mapreg gets the country region from the individual php files
- The query is stored in the $myquery variable which gets the count of organization and the name of a particular country for that particular region
- The data is then passed to the php file using the $data variable.

### Leaflet Code in any of the php file
- The code in all the php files is very much the same and can be combined into a single file in the future.
- It sets the mapreg variable to the particular region and then calls the dbconnect.php file.
- Next step is to set the basemap layer using the maplayer variable.
- The map variable is used to set the zoom of the map and the boundaries.
- Info.Add is used to add the Information on the top right of the map.
- Getcolor function is used to get the color of the country according to the number of organization.
- Style function is used to style the data.
- The highlightFeature function is activated when the mouse is hovered over a particular country.
- The resetHighlight is activated as soon as you hover away from the region
- OnEachFeature is used to process the geojson data and respond to mouseover and mouseout events.
- Count contains the total number of rows acquired from the dbconnect.php file.
Regions variable contains the geoJSON data for which we use the for loop to process and manipulate.
- We match the ios2 code from $data.iso2 obtained from dbconnect.php file and the iso2 code from regions to change the regions.AREA property to the number of organizations for that particular country.
- The legend.onAdd is used to add the legend on the botton right of the map
