import os

class BaseSettings(object):

    def __init__(self):
        self.agol_user = os.environ.get('AGOL_USER', '')  # - add ArcGIS Online User ID or set environment variable
        self.agol_pass = os.environ.get('AGOL_PASS', '')  # - add ArcGIS Online User Pass or set environment variable
        # self.parse_data_endpoint = 'http://54.210.82.88/survey/data/flatfile.json'
        self.parse_data_endpoint = 'http://opendataimpactmap.org/survey/data/flatfile.json'
        # self.arcgis_source_file = 'arcgis_flatfile.json'
        self.max_character_limit = 1024
        self.country_centroid_lookup_table = os.path.join(os.path.dirname(__file__), 'country_centroids_all.csv')

class DevelopmentSettings(BaseSettings):

    def __init__(self):
        BaseSettings.__init__(self)
        self.environment = "AGOL Development"        
        self.agol_feature_service_url = 'https://services7.arcgis.com/6B5Of8bXgHVo93zg/arcgis/rest/services/ode_organizations_dev_2017/FeatureServer/0'

class StagingSettings(BaseSettings):

    def __init__(self):
        BaseSettings.__init__(self)
        self.environment = "AGOL Staging"        
        self.agol_feature_service_url = 'https://services7.arcgis.com/6B5Of8bXgHVo93zg/arcgis/rest/services/ode_organizations_dev_2017/FeatureServer/0'
        

class ProductionSettings(BaseSettings):

    def __init__(self):
        BaseSettings.__init__(self)
        self.environment = "AGOL Production"        
        #self.agol_feature_service_url = 'https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_prod_07302015/FeatureServer/0'
        self.agol_feature_service_url = 'https://services7.arcgis.com/6B5Of8bXgHVo93zg/arcgis/rest/services/ode_organizations_prod_2017/FeatureServer/0'

# - set active environment to 'development', 'staging', or 'production' with default being 'development'
agol_env = os.environ.get('AGOL_ENV', 'development')
if os.environ.get('AGOL_ENV') == 'development':
    env = DevelopmentSettings()
if os.environ.get('AGOL_ENV') == 'staging':
    env = StagingSettings()
if os.environ.get('AGOL_ENV') == 'production':
    env = ProductionSettings()

# - logging helper
import logging
import logging.handlers

def get_logger(file_name, logger_name='AppLogger', level=logging.INFO, return_handlers=False):

    # - logging setup
    log_formater = logging.Formatter("%(asctime)s    %(threadName)s    %(levelname)s    %(message)s")
    logger = logging.getLogger(logger_name)

    file_handler = logging.handlers.RotatingFileHandler(file_name, maxBytes=1024*1024*10, backupCount=1)
    file_handler.setFormatter(log_formater)
    file_handler.setLevel(level)
    logger.addHandler(file_handler)

    stream_handler = logging.StreamHandler()
    stream_handler.setFormatter(log_formater)
    stream_handler.setLevel(level)
    logger.addHandler(stream_handler)

    if return_handlers:
        return logger, [file_handler, stream_handler]

    return logger
