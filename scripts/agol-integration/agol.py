# -*- coding: utf-8 -*-

import json
import os
import urllib
import urllib2
import unittest
import requests
import pandas
from settings import get_logger

logger = get_logger('agol_integration.log', __name__)

def chunker(seq, size):
    return (seq[pos:pos + size] for pos in xrange(0, len(seq), size))

def featureset_to_dataframe(featureset, convertGeometry=False, useAliases=False):
    items = []
    for f in featureset['features']:
        base_item = f['attributes']
        if f.has_key('geometry'):
            base_item['geometry'] = f['geometry']
        items.append(base_item)

    df = pandas.DataFrame(items)
    if useAliases and featureset.get('fieldAliases'):
        df.rename(columns=featureset['fieldAliases'], inplace=True)
    if convertGeometry:
        pass
    return df

def get_service_info(service_layer, token):

    params = {}
    params['f'] = 'json'
    params['token'] = token

    r = requests.get(service_layer, params=params)
    r.raise_for_status()
    return r.json()

def flush_and_replace_feature_layer(target_layer, replacement_layer, token):

    delete_features(target_layer, '1=1', token)
    
    if isinstance(replacement_layer, basestring):
        replacement_content = query_to_dataframe(replacement_layer, '1=1', returnGeometry=True, token=token)
    elif isinstance(replacement_layer, pandas.DataFrame):
        replacement_content = replacement_layer
    
    features = []
    for f in replacement_content.to_dict('records'):
        feat = {}
        feat['attributes'] = {k:v for k,v in f.items() if k != 'geometry' }
        feat['geometry'] = f['geometry']
        features.append(feat)
    print "target_layer: %s" % target_layer
    add_features(target_layer, features, token=token)

def dataframe_to_featureset(dataFrame):
    dicts = dataFrame.to_dict(orient='records')
    features = [{'attributes':d} for d in dicts]
    return json.dumps(features)

def dataframe_to_point_features(df, x_field, y_field, wkid=4326):
    def create_point_feature(d):
        f = {}
        f['attributes'] = d
        f['geometry'] = {}
        f['geometry']['x'] = d[x_field]
        f['geometry']['y'] = d[y_field]
        f['geometry']['spatialReference'] = {'wkid':wkid}
        return f

    dicts = df.to_dict(orient='records')
    return [create_point_feature(d) for d in dicts]

def do_post(url, param_dict, proxy_url=None, proxy_port=None):
    """ performs the POST operation and returns dictionary result """
    if proxy_url is not None:
        if proxy_port is None:
            proxy_port = 80
        proxies = {"http":"http://%s:%s" % (proxy_url, proxy_port),
                   "https":"https://%s:%s" % (proxy_url, proxy_port)}
        proxy_support = urllib2.ProxyHandler(proxies)
        opener = urllib2.build_opener(proxy_support, urllib2.HTTPHandler(debuglevel=1))
        urllib2.install_opener(opener)

    request = urllib2.Request(url, urllib.urlencode(param_dict))
    result = urllib2.urlopen(request).read()
    if result == "":
        return ""
    jres = json.loads(result)
    if 'error' in jres:
        if jres['error']['message'] == 'Request not made over ssl':
            if url.startswith('http://'):
                url = url.replace('http://', 'https://')
                return do_post( url, param_dict, proxy_url, proxy_port)

    return jres #todo add unicode conversion?

def generate_token(username, password):
    """ generates a token for a feature service """
    referer = r'https://www.arcgis.com'
    tokenUrl  = r'https://www.arcgis.com/sharing/rest/generateToken'

    params = {'username': username,
                  'password': password,
                  'expiration': str(60),
                  'referer': referer,
                  'f': 'json'}

    r = requests.post(tokenUrl, data=params)
    r.raise_for_status()
    j = r.json()
    return j['token']

def add_tags(tags, token):
    url = os.path.join(agol_settings.agol_base, 'sharing/rest/community/users', agol_settings.username, 'tags')
    response = requests.get(url)

def is_service_name_available(name, serviceType, token):
    url = os.path.join(agol_settings.agol_base, 'sharing/rest/portals', agol_settings.agol_id, 'isServiceNameAvailable')
    params = {}
    params['name'] = name
    params['type'] = serviceType
    params['f'] = 'json'
    params['token'] = token

    result = requests.get(url, params=params)
    return result.json()['available']

def create_feature_service(name, token):
    if not is_service_name_available(name, 'Feature Service', token):
        print 'sorry name not available'
        return

    url = os.path.join(agol_settings.agol_base, 'sharing/rest/content/users', agol_settings.agol_user, 'createService')

    editor_tracking_info = {}
    editor_tracking_info['enableEditorTracking'] = False
    editor_tracking_info['enableOwnershipAccessControl'] = False
    editor_tracking_info['allowOthersToUpdate'] = True
    editor_tracking_info['allowOthersToDelete'] = True

    xssPreventionInfo = {}
    xssPreventionInfo['xssPreventionEnabled'] = True
    xssPreventionInfo['xssPreventionRule'] = 'InputOnly'
    xssPreventionInfo['xssInputRule'] = 'rejectInvalid'
    xssPreventionInfo['allowOthersToDelete'] = True

    create_params = {}
    create_params['currentVersion'] = 10.21
    create_params['serviceDescription'] = '10.21'
    create_params['hasVersionedData'] = False
    create_params['supportsDisconnectedEditing'] = False
    create_params['hasStaticData'] = False
    create_params['maxRecordCount'] = 2000
    create_params['supportedQueryFormats'] = "JSON"
    create_params['capabilities'] = "Query,Editing,Create,Update,Delete"
    create_params['description'] = ''
    create_params['copyrightText'] = ''
    create_params['allowGeometryUpdates'] = True
    create_params['syncEnabled'] = False
    create_params['size'] = 9076736
    create_params['editorTrackingInfo'] = editor_tracking_info
    create_params['xssPreventionInfo'] = xssPreventionInfo
    create_params['tables'] = []
    create_params['_ssl'] = False
    create_params['name'] = name

    params = {}
    params['createParameters'] = {}
    params['targetType'] = 'featureService'
    params['f'] = 'json'
    params['token'] = token

    result = requests.post(url, params=params)
    return result

def create_layer_object():

    editing_info = {}
    editing_info['lastEditDate'] = None

    advanced_query_capabilities = {}
    advanced_query_capabilities['supportsPagination'] = True
    advanced_query_capabilities['supportsQueryWithDistance'] = True
    advanced_query_capabilities['supportsReturningQueryExtent'] = True
    advanced_query_capabilities['supportsStatistics'] = True
    advanced_query_capabilities['supportsOrderBy'] = True
    advanced_query_capabilities['supportsDistinct'] = True
    advanced_query_capabilities['supportsPagination'] = True

    sr = {}
    sr['wkid'] = 102100

    extent = {}
    extent['xmin']
    extent['ymin']
    extent['xmax']
    extent['ymax']
    extent['spatialReference'] = sr

    layer = {}
    layer['currentVersion'] = 10.21
    layer['id'] = 0
    layer['name'] = 'BRA_adm0'
    layer['type'] = 'Feature Layer'
    layer['displayField'] = ''
    layer['description'] = ''
    layer['copyrightText'] = ''
    layer['defaultVisibility'] = True
    layer['type'] = 'Feature Layer'
    layer['editingInfo'] = editing_info
    layer['relationships'] = []
    layer['isDataVersioned'] = False
    layer['supportsCalculate'] = True
    layer['supportsAttachmentsByUploadId'] = True
    layer['supportsRollbackOnFailureParameter'] = True
    layer['supportsStatistics'] = True
    layer['supportsAdvancedQueries'] = True
    layer['advancedQueryCapabilities'] = advanced_query_capabilities
    layer['geometryType'] = 'esriGeometryPolygon'
    layer['minScale'] = 0
    layer['maxScale'] = 0

    layer['extent'] = extent
    layer['supportsStatistics'] = True
    layer['supportsStatistics'] = True
    layer['supportsStatistics'] = True
    layer['supportsStatistics'] = True
    layer['supportsStatistics'] = True
    layer['supportsStatistics'] = True

    return layer

def check_response(r):
    r.json()
    r.json()['addResults']

def add_features(url, features, token):
    add_url = url + '/addFeatures'
    add_count = 0
    successes = []
    errors = []

    for feature_chunk in chunker(features, 100):
        params = {}
        params['features'] = json.dumps(feature_chunk, encoding='latin-1')
        params['f'] = 'json'
        params['token'] = token
        r = requests.post(add_url, data=params)
        
        try:
            check_response(r)
        except:
            r = requests.post(add_url, data=params)
            try:
                check_response(r)
            except:
                r = requests.post(add_url, data=params)
                try:
                    check_response(r)
                except:
                    r = requests.post(add_url, data=params)
                    try:
                        check_response(r)
                    except:
                        r = requests.post(add_url, data=params)

        if 'addResults' not in r.json().keys():
            print r.json()
            raise KeyError('Failed to add features to AGOL')

        for n, i in enumerate(r.json()['addResults']):
            if not i.get('success'):
                errors.append(feature_chunk[n])
                print i
            else:
                successes.append(feature_chunk[n])

        print 'successfully added {} items, failed to add {} items to {}'.format(len(successes), len(errors), url)
        
    return successes, errors 

def update_features(url, dataframe, token):

    if isinstance(dataframe, pandas.DataFrame):
        df_json = dataframe_to_featureset(dataframe)
    elif isinstance(dataframe, list):
        df_json = json.dumps([{'attributes':d} for d in dataframe], encoding='latin-1')

    update_url = url + '/updateFeatures'

    params = {}
    params['Features'] = df_json
    params['f'] = 'json'
    params['token'] = token
    r = requests.post(update_url, data=params)
    r.raise_for_status()

    if r.json() and 'updateResults' in r.json().keys():
        print 'updated {} items from {}'.format(len(r.json()['updateResults']), url)
    else:
        print r.json()
        raise Exception('AGOL Update Failed')
    return r

def delete_features(url, where, token):
    delete_url = url + '/deleteFeatures'
    params = {}
    params['where'] = where
    params['f'] = 'json'
    params['token'] = token
    r = requests.post(delete_url, data=params)
    r.raise_for_status()
    if r.json() and 'deleteResults' in r.json().keys():
        print 'deleted {} items from {}'.format(len(r.json()['deleteResults']), url)
    else:
        print r.json()
    return r

def query_to_dataframe(layer, where='1=1', token=None, outFields='*', 
                        chunkSize=100, useAliases=True, 
                        geometry=None, geometryType='esriGeometryPolygon', 
                        inSR=102100, returnGeometry=False, debug=False):
    featureset = query_layer(layer, where, token, outFields, chunkSize, geometry, geometryType, inSR, returnGeometry)
    return featureset_to_dataframe(featureset, useAliases=useAliases)

def query_layer(layer, where='1=1', token=None, outFields='*', 
                        chunkSize=100,  geometry=None, geometryType='esriGeometryPolygon', 
                        inSR=102100, returnGeometry=False, outSr=None):
    url = layer + r'/query'

    g = None
    if geometry:
        if isinstance(geometry, basestring):
            g = geometry
        else:
            g = json.dumps(geometry)

    params = {}
    params['where'] = where
    params['outFields'] = outFields
    params['returnGeometry'] = returnGeometry
    params['token'] = token
    params['f'] = 'json'
    params['returnIdsOnly'] = True

    if outSr:
        params['outSr'] = outSr
    if g:
        params['geometry'] = g
        params['geometryType'] = geometryType
        params['inSR'] = inSR
    
    ids_req = requests.post(url, data=params)
    ids_req.raise_for_status()
    oid_field_name = ids_req.json().get('objectIdFieldName')
    ids_response = ids_req.json().get('objectIds')
    params['returnIdsOnly'] = False
    params['where'] = ''
    if not ids_response:
        logger.warn('Empty response:' + str(ids_req.json()) )
        featureset = {}
        featureset['features'] = []
        return featureset

    featureset = None
    for ids in chunker(ids_response, chunkSize):
        params['objectIds'] = ','.join(map(str, ids))
        req = requests.post(url, data=params)
        req.raise_for_status()
        feat_response = req.json()
        if not featureset:
            featureset = feat_response
        else:
            featureset['features'] += feat_response['features']
    if not featureset:
        featureset = {}
        featureset['features'] = []

    return featureset
