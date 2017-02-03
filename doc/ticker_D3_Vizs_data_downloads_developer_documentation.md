# Overview
In addition to Webflow, custom code are used to achieve certain UI features, D3 vizs/leaflet vizs, and data downloads. They share similar file structures and utilize one DB config file for connecting to DB. The code structure will be explained below.

On home page and each individual region/sector pages, there are counting up ticker numbers of countries or orgnizations. The counting up effect is achieved using custom code and will be explained below.

On region & sector high-level findings page, and each individual region & sector page, all containers for vizs are created in Webflow and given a unique ID. Then custom JS code is used with the downloaded Webflow files to draw vizs in the containers.

For visualizations, this doc only explains the ones that draw D3 charts. For regional maps that implemented with Leaflet, please refer to 'region_maps'.

# Explanation of folders and files

## For D3 vizs (pie charts and bar charts, excluding the region maps)
#### Folder - html/css-custom

This folder stores two style sheets, one for regional maps (mapstyle.css), and one for D3 vizs (viz-style.css).

Shape and color for SVG elements are specified in this stylesheet.

Hover effect are usually achieved by CSS hover properties.
1. `.d3-tip` class is styling that comes with D3 tooltip plugin.
2. `xxx:hover` is for specifying styling changes when mouse cursor hovers over an SVG element.

#### Folder - html/js-custom/viz

This folder stores all the JS scripts for D3 charts on region/sector high-level pages, and individual pages.

'regionViz' folder stores all JS code for regional vizs. 

###### At the top level within the 'regionViz' folder, 'RegionLandingBarData.php' and 'viz-regionLanding.js' are for drawing and getting data for the chart on high-level region page.

`'RegionLandingBarData.php'`:
1. `$data` is an array of numbers that will be turned into JSON at the end of the scrpit to feed the visualizations.
2. Depending on the vizs, numbers of queries are executed sequentially. 
3. The query return value is extracted from `$result` and stored in `$obj`, then pushed into `$data` array each time an query is succefully executed.

`'viz-regionLanding.js'`:
1. Basic chart dimensions (axises, scales, margins, height/width) are defined on top of the script.
2. `drawOrdDist()` is the function to draw high-level bar chart on landing page.
3. In the function `drawOrdDist()`, it will first capture the `<div>` container created by Webflow, then draw the SVG canvas, parse data to create the domain, and finally draw charts according to the domain and scale.

###### The 'regionViz' folder also contains seven folders for seven regions. Within each of the seven folders, there are two JS scripts for drawing two shapes of charts, and four PHP scripts for getting data for all four charts. 

1. Each of the PHP scripts is responsible for getting data for one chart. e.g. the `EAPAgePieData.php` script is for getting data for the organization age pie chart. These PHP scripts are constructed the same way as the top-level PHP script.
2. Each JS script is for drawing within each Webflow container. e.g. On each individual region page, there are one container holding three pie charts, and one container holding a bar chart. `viz-EAP-pie.js` is for drawing three pie charts within that container. These JS scripts are constructed the same way as the top-level JS script.

Similarly, 'sectorViz' folder stores all JS code for sectoral vizs. 
###### At the top level within the 'sectorViz' folder, 'SectorLandingBarData.php' and 'viz-sectorLanding.js' are for drawing and getting data for the two charts on high-level sector page separately.
###### It contains thirteen folders for thirteen sectors. Within each of the thirteen folders, there are three JS scripts for drawing three shapes of charts, and five PHP scripts for getting data for all five charts. 

## For ticker number counting up effect
#### Folder html/js-custom/countUp

This folder stores all the JS scripts for the counting up effect on all ticker numbers on home page and individual sector/region pages.

###### On the top level of the folder, the JS script is for counting up numbers, and two PHP scripts are for getting numbers for two tickers.
1. e.g. `home_case_ticker.php` is for getting the case ticker number.
2. The `getHomeStat.js` script has two ajax process at the end of the script for getting the numbers.
3. Then, the function on top will animate the number by counting it up.
4. The intervals, steps, etc. of counting up animation can be specified in `$.fn.countTo.defaults = {}`. 

###### Within the 'countUp' folder, there are also two folders - 'region' for counting up all regional tickers, and 'sector' for counting up all sectoral tickers. Within each region/sector sub-folder, there are one JS script for counting up effect and one PHP script for getting the data.
1. The PHP and JS code are constructed the same as the top level codes.
2. Now the JS script only has one ajax process to get one number.



## For downloading CSV/JSON data on each individual page & Use Cases page Machine Readability view
#### Folder html/js-custom/indi_data_download

This folder stores all the JS scripts for downloading JSON/CSV data files on individual sector/region pages and Use Cases page Machine Readability view.

###### On the top level of the folder, the 'download_MR_orgs.php' script is used for downloading Machine Readability org `CSV` data on Use Cases page.
1. The `orgProfile` class initiates all data columns that will appear in the final downloaded file.
2. `$row` stores all columns data for each loop.
3. Corresponding data is pushed into `$profiles[]` which is an instance of the `orgProfile` class.
4. Finally, use `fopen` and `fputcsv` to generate CSV file in the PHP output stream when the script is triggered.

###### Within the folder, there are two folders - 'region' and 'sector' containing 7 region sub-folders and 13 sector sub-folders respectively. Within each region/sector sub-folder, there are one PHP script for downloading JSON data and one PHP script for downloading CSV data.
1. Each PHP script for CSV download is contructed the same as the top level PHP script, with slightly different queries.
2. Each PHP script for JSON download is also constructed the same, except for at the end it uses json_encode to output data in JSON format.


## DB credential
PHP file - 'html/js-custom/db_config.php' stores the DB credentials for all D3 vizs, ticker numbers, and data downloads PHP scripts to connect to the DB.