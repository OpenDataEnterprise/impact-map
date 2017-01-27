# Overview
In addition to Webflow, custom code are used to achieve certain UI features, D3 vizs/leaflet vizs, and data downloads. They share similar file structures and utilize one DB config file for connecting to DB. The code structure will be explained below.

On home page and each individual region/sector pages, there are counting up ticker numbers of countries or orgnizations. The counting up effect is achieved using custom code and will be explained below.

On region & sector high-level findings page, and each individual region & sector page, all containers for vizs are created in Webflow and given a unique ID. Then custom JS code is used with the downloaded Webflow files to draw vizs in the containers.

For visualizations, this doc only explains the ones that draw D3 charts. For regional maps that implemented with Leaflet, please refer to 'region_maps'.

# Explanation of folders and files

## For D3 vizs
#### Folder - html/css-custom

This folder stores two style sheets, one for regional maps (mapstyle.css), and one for D3 vizs (viz-style.css).

#### Folder - html/js-custom/viz

This folder stores all the JS scripts for D3 charts on region/sector high-level pages, and individual pages.

'regionViz' folder stores all JS code for regional vizs. It contains seven folders for seven regions. Within each of the seven folders, there are two JS scripts for drawing two shapes of charts, and four PHP scripts for getting data for all four charts. At the top level within the 'regionViz folder', 'RegionLandingBarData.php' and 'viz-regionLanding.js' are for drawing and getting data for the chart on high-level region page.

Similarly, 'sectorViz' folder stores all JS code for sectoral vizs. It contains thirteen folders for thirteen sectors. Within each of the thirteen folders, there are three JS scripts for drawing three shapes of charts, and five PHP scripts for getting data for all five charts. At the top level within the 'sectorViz' folder, 'SectorLandingBarData.php' and 'viz-sectorLanding.js' are for drawing and getting data for the two charts on high-level sector page separately.

## For ticker number counting up effect
#### Folder html/js-custom/countUp

This folder stores all the JS scripts for the counting up effect on all ticker numbers on home page and individual sector/region pages.

Within the folder, there are two folders - 'region' for counting up all regional tickers, and 'sector' for counting up all sectoral tickers. Within each region/sector sub-folder, there are one JS script for counting up effect and one PHP script for getting the data.

On the top level of the folder, the JS script is for counting up numbers, and two PHP scripts are for getting numbers for two tickers.

## For downloading CSV/JSON data on each individual page & Use Cases page Machine Readability view
#### Folder html/js-custom/indi_data_download

This folder stores all the JS scripts for downloading JSON/CSV data files on individual sector/region pages and Use Cases page Machine Readability view.

Within the folder, there are two folders - 'region' and 'sector' containing 7 region sub-folders and 13 sector sub-folders respectively. Within each region/sector sub-folder, there are one PHP script for downloading JSON data and one PHP script for downloading CSV data.

On the top level of the folder, the 'download_MR_orgs.php' script is used for downloading Machine Readability org data on Use Cases page.

## DB credential
PHP file - 'html/js-custom/db_config.php' is used for all D3 vizs, ticker numbers, and data downloads to connect to DB.