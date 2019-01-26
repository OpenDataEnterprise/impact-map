## ArcGIS Online Integration Job

# Greg's Notes

add the rest/admin -- add the 'admin'
https://services7.arcgis.com/6B5Of8bXgHVo93zg/arcgis/rest/admin/services/agol_service_schema/FeatureServer
click the 'Update Definition' to change the record count

change in agol_service_schema and dev, production, etc. inherit from it


Addressing seeing items

# Brendan's Notes

The following code synchronizes data from a local JSON file to an ArcGIS Online hosted-feature-service.

#####Development Version:
- https://services7.arcgis.com/6B5Of8bXgHVo93zg/arcgis/rest/services/ode_organizations_dev_2017/FeatureServer/0

#####Staging Version:
- https://services7.arcgis.com/6B5Of8bXgHVo93zg/arcgis/rest/services/ode_organizations_dev_2017/FeatureServer/0

#####Production Version:
- https://services7.arcgis.com/6B5Of8bXgHVo93zg/arcgis/rest/services/ode_organizations_prod_2018/FeatureServer/0

####Setup

- Install the latest version of Python 2.7.  If < 2.7.9, install PIP also:

        $> yum install python
        $> yum install python-devel
        $> yum install python-pip

- Install 3rd-party python packages:

        $> cd ./scripts/agol-integration
        $> pip install -r requirements.txt


Running this job requires user credentials for ArcGIS Online with at minimum `publisher` level role. 

Set credentials by either:

- Adding credentials directly to `settings.py` file:

        import os

        class BaseSettings(object):

            def __init__(self):
                self.agol_user = os.environ.get('AGOL_USER', '<my user name>') # - add ArcGIS Online User ID or set environment variable
                self.agol_pass = os.environ.get('AGOL_PASS','<my user password>')  # - add ArcGIS Online User Pass or set environment variable

- Setting environment variables (edit `/etc/profile.d`):

        export AGOL_USER=<my user name>
        export AGOL_PASS=<my user password>

####Initial Service Setup

To create services from scratch, first create a schema file(.csv) based on your input file(.json):

    $> python agol_integration/agol_integration.py build_schema <input_file.json> <output_file.csv>

This schema file(.csv) can then be uploaded into ArcGIS Online > My Content and can be used as a template to create a `dev`, `staging`, and `production` feature services.

####Setup Max Record Count on Template Service

- Once a template service is created, browse to the rest admin endpoint:

    `https://services7.arcgis.com/6B5Of8bXgHVo93zg/arcgis/rest/admin/services/agol_service_schema/FeatureServer`

- At the bottom of the screen, you should see a link to `Update Definition`

- In the JSON object which appears, change "maxRecordCount" to `120000`

- Go back to .../rest/admin/services/agol_service_schema/FeatureServer

- Select the first layer (organizations), and at the bottom of the screen click "Update Definition". At the bottom of the JSON object in the window, you will notice `maxRecordCount`. Change this value to 120000`.

- Click "Update Layer Definition", if you get an error about "Last Edit Date", then change `lastEditDate` to an empty string.


####Additional Script Configuration
To configure the location of the local file for import into the ArcGIS Online, edit the following line in `settings.py`:

    self.arcgis_source_file = 'arcgis_flatfile.json'

####Switching Environments (i.e. Development, Staging, Production)
The agol_integration script will target only one environment at a time.  To change which environment is active, edit the following line in `settings.py`:

    env = DevelopmentSettings()

Valid environment values include: `DevelopmentSettings`, `StagingSettings`, and `ProductionSettings`

####Scheduling
Add script to crontab:

        22 4 * * 0 root <install_path>/scripts/agol-integration/arcgis_online_sync.sh

####Testing
To run associated tests (Note: No matter what environment you set in `settings.env`, tests will always runs with `settings.DevelopmentSettings`):

    $> cd ./scripts/agol-integration
    $> nosetests -v


    ----------------------------------------------------------------------
    Ran 3 tests in 4.643s

    OK


