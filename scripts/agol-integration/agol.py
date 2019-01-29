import json
import os
import urllib
import unittest
import requests
import pandas


class AGOLRequestException(Exception):
    pass


def chunker(seq, size):
    return (seq[pos:pos + size] for pos in range(0, len(seq), size))


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


def generate_token(username, password):
    """Generates a service token."""

    referer = 'https://www.arcgis.com'
    endpoint  = 'https://www.arcgis.com/sharing/rest/generateToken'

    params = {
        'username': username,
        'password': password,
        'expiration': str(60),
        'referer': referer,
        'f': 'json'
    }

    r = requests.post(endpoint, data=params)

    r.raise_for_status()
    j = r.json()
    return j['token']


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
        params['features'] = json.dumps(feature_chunk)
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
            print(r.json())
            raise KeyError('Failed to add features to AGOL')

        for n, i in enumerate(r.json()['addResults']):
            if not i.get('success'):
                errors.append(feature_chunk[n])
                print(i)
            else:
                successes.append(feature_chunk[n])

        print('Successfully added {} items, failed to add {} items to {}'.format(len(successes), len(errors), url))

    return successes, errors


def truncate_layer(url, token):
    """Removes all features from an ArcGIS feature layer."""

    # See ArcGIS REST API documentation on Truncate (Feature Layer).
    endpoint = url + '/deleteFeatures'

    # Set params for request.
    params = {
        'f': 'json',
        'where': '1=1',
        'token': token,
    }

    # Send request and grab response.
    response = requests.post(endpoint, data=params)

    # Raise exception if request itself has a problem.
    response.raise_for_status()

    # Retrieve response body in JSON format.
    response_json = response.json()

    if response_json and 'error' in response_json.keys():
        # Raise exception if ArcGIS could not successfully handle the request.
        raise AGOLRequestException(response_json['error'])
    elif response_json and 'deleteResults' in response_json.keys():
        print('Deleted {} items from {}'.format(
            len(response_json['deleteResults']), endpoint))
    else:
        print(response_json)

    return response_json
