import os

class BaseSettings(object):

    def __init__(self):
        self.agol_user = os.environ.get('AGOL_USER', '')  # - add ArcGIS Online User ID or set environment variable
        self.agol_pass = os.environ.get('AGOL_PASS', '')  # - add ArcGIS Online User Pass or set environment variable
        self.json_data_endpoint = 'http://opendataimpactmap.org/survey/data/flatfile.json'
        self.max_character_limit = 1024
        self.country_centroid_lookup_table = os.path.join(os.path.dirname(__file__), 'country_centroids_all.csv')

class DevelopmentSettings(BaseSettings):

    def __init__(self):
        BaseSettings.__init__(self)
        self.environment = "AGOL Development"        
        self.feature_service_url = 'https://services7.arcgis.com/6B5Of8bXgHVo93zg/arcgis/rest/services/ode_organizations_dev_2017/FeatureServer/0'

class StagingSettings(BaseSettings):

    def __init__(self):
        BaseSettings.__init__(self)
        self.environment = "AGOL Staging"        
        self.feature_service_url = 'https://services7.arcgis.com/6B5Of8bXgHVo93zg/arcgis/rest/services/ode_organizations_dev_2017/FeatureServer/0'
        

class ProductionSettings(BaseSettings):

    def __init__(self):
        BaseSettings.__init__(self)
        self.environment = "AGOL Production"        
        self.feature_service_url = 'https://services7.arcgis.com/6B5Of8bXgHVo93zg/arcgis/rest/services/ode_organizations_prod_2018/FeatureServer/0'


# Set active environment with 'development' as default.
agol_env = os.environ.get('AGOL_ENV', 'development')

if agol_env == 'development':
    env = DevelopmentSettings()
elif agol_env == 'staging':
    env = StagingSettings()
elif agol_env == 'production':
    env = ProductionSettings()
