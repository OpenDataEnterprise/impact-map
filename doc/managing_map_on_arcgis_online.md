Managing the Map Visualization and Data on ArcGIS Online
========================================================

# Update the Map Visualization (Publishing profiles to ArcGIS Online)

The map is updated by publishing data from the Parse.com database to ArcGIS Online Feature service. Publishing fresh data involves the following steps:

1. Opening a terminal
2. Navagating to the directory with the `agol_integration.py` script
3. Setting environment variables to access AGOL and set target feature
4. Running python script
5. Checking output

The `agol_integration.py` script requires username and password and target feature enviornment (development, staging, production) to  be set.
(Service being used by map is defined in the file `html/map/viz/app/js/map/map_config.js`.)

#### Example terminal session of these steps:

```
# navigate to repository
cd /path/projects/odesurvey

# download the most up-to-date scripts (just in case)
git pull origin master

# navigate to directory with agol_integration.py script
cd scripts/agol-integration/agol_integration

# set environmental variables
AGOL_USER=myuserame
export AGOL_USER
AGOL_PASS=mypassword
export AGOL_PASS
AGOL_ENV=development
export AGOL_ENV

# Run agol_integration.py
python agol_integration.py

```

*NOTE* If you receive an error starting with "InsecurePlatformWarning: A true SSLContext object is not available. This prevents urllib3 from configuring SSL appropriately and may cause certain SSL connections to fail...", correct this issue by installing requests-security module using pip with the shell command: `sudo pip install requests[security]`

AGOL_ENV setting       | Data published for access by servers | URL
-----------------------|-------------------------------------|-----
`AGOL_ENV=development` | development, staging | (not shared)
`AGOL_ENV=staging`     | staging     | (not shared)
`AGOL_ENV=production`  | production  | http://www.opendataenterprise.org/map/viz/index.html

#### Example terminal session output from command `python agol_integration.py`
```

Parsing data from json file http://www.opendataenterprise.org/map/survey/data/flatfile.json
found 0 problematic records (see problem_records.json)
Updating AGOL Development environment schema https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0 for account myuserame
/Library/Python/2.7/site-packages/pandas/util/decorators.py:81: FutureWarning: the 'outtype' keyword is deprecated, use 'orient' instead
  warnings.warn(msg, FutureWarning)
deleted 2728 items from https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 100 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 200 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 300 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 400 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 500 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 600 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 700 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 800 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 900 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 1000 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 1100 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 1200 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 1300 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 1400 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 1500 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 1600 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 1700 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 1800 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 1900 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 2000 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 2100 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 2200 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 2300 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 2400 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 2500 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 2600 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 2700 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 2728 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
```

# Dev / Staging / Production for Map

### In the viz app source files

In the file `viz-src/src/app/js/map/map_config.js` the first few lines set up where the application gets the data:11
```
  var agsserver = "https://services5.arcgis.com/w1WEecz5ClslKH2Q/ArcGIS/rest/services";
  var runAs = 'develop';
  var mode = {
    'develop': 'ode_organizations_dev',
    'staging': 'ode_organizations_staging',
    'production': 'ode_organizations_dev'
  }
```

To change the service the application pulls from in the source you need to change the line to which mode you’d like: ‘develop’, ‘staging’, ‘production'

```
  var runAs = 'develop’;
```

### In the viz app compiled files

These lines are compiled into the file `html/map/viz/app/js/map/map_config.js` to be displayed as:
```
  var e="https://services5.arcgis.com/w1WEecz5ClslKH2Q/ArcGIS/rest/services",a="develop",t={develop:"ode_organizations_dev",staging:"ode_organizations_staging",production:"ode_organizations_dev"},
```

To change the service the application pulls from in the compiled app change the value to which mode you’d like: ‘develop’, ‘staging’, ‘production'

```
  a="develop"
```

AGOL Python Integration:
To change to service to be updated when running the script:

In the file scripts/agol-integration/agol-integration/settings.py there are three class, one for each of the environments:

```
class DevelopmentSettings(BaseSettings):
    def __init__(self):
        BaseSettings.__init__(self)
        self.agol_feature_service_url = 'https://services5.arcgis.com/w1WEecz5ClslKH2Q/arcgis/rest/services/ode_organizations_dev/FeatureServer/0'

class StagingSettings(BaseSettings):
    def __init__(self):
        BaseSettings.__init__(self)
        self.agol_feature_service_url = 'https://services5.arcgis.com/w1WEecz5ClslKH2Q/arcgis/rest/services/ode_organizations_staging/FeatureServer/0'

class ProductionSettings(BaseSettings):
    def __init__(self):
        BaseSettings.__init__(self)
        self.agol_feature_service_url = 'https://services5.arcgis.com/w1WEecz5ClslKH2Q/arcgis/rest/services/ode_organizations_production/FeatureServer/0'
```

# Updating ArcGIS Online Schema

When updating ArcGIS Online Schema be sure to do the following:

1. Make sure the Schema is available to everyone
2. Update the service definition from default 1000 records to greater than or equal to the number of being uploaded (e.g., 12000 is a good number). To update the service use the url that includes `ArcGIS/rest/admin` as in: `http://services.arcgis.com/[appid]/arcgis/rest/admin/services/ode_organizations_schema_07302015/FeatureServer/0/updateDefinition`
