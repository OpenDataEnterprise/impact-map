#!/usr/bin/env python
# - std lib

#
# Usage
#   AGOL_USER=<username>
#   export AGOL_USER
#   AGOL_PASS=<password>
#   export AGOL_PASS
#   AGOL_ENV=<development | staging | production>
#   export AGOL_ENV
#   python agol_integration.py
#

import json
import sys
import pdb
import urllib2
from functools import partial

# - 3rd party
import pandas

# - local
import agol


def get_parse_content(json_file):
    print "Parsing data from json file %s" % json_file

    if json_file.find("http") > -1:
        content_response = json.loads(urllib2.urlopen(json_file).read())
        print "JSON record size: %d" % len(content_response['results'])
        if 'results' in content_response.keys():
            df = pandas.DataFrame(content_response['results'])
            return df
    else:
        with open(json_file, 'r') as d:
            content_response = json.loads(d.read())
            if 'results' in content_response.keys():
                df = pandas.DataFrame(content_response['results'])
                return df

def output_problem_rows(df):
    df_problems = df[df.latitude.isnull() | df.longitude.isnull()]

    results = {}
    results['results'] = df_problems.to_dict(orient='records')

    with open('problem_records.json', 'w') as output_file:
        output_file.write(json.dumps(results))

    print 'found {} problematic records (see problem_records.json)'.format(len(df_problems))

def refresh_agol(source_df, destination_feature_service_layer, token):
    features = agol.dataframe_to_point_features(source_df, x_field='longitude', y_field='latitude', wkid=4326)
    agol.delete_features(destination_feature_service_layer, where='1=1', token=token)
    successes, errors = agol.add_features(destination_feature_service_layer, features, token=token)
    
    with open('agol_success.json', 'w') as success_file:
        if successes:
            print "Number of features written to AGOL: %d" % len(successes)
            success_file.write(json.dumps(successes))
    
    with open('agol_error.json', 'w') as error_file:
        if errors:
            success_file.write(json.dumps(errors))

    return True

def create_schema_file(input_file, output_file):
    with open(input_file, 'r') as data:
        j = json.loads(data.read())['results']
        df = pandas.DataFrame(j)
        df.head(2).to_csv(output_file, index=False, encoding='utf8')

def clean_row(lookup_table, row):

    if not row['latitude'] and lookup_table.get(row['org_hq_country']):
        row['latitude'] = lookup_table.get(row['org_hq_country'])[1]

    if not row['longitude'] and lookup_table.get(row['org_hq_country']):
        row['longitude'] = lookup_table.get(row['org_hq_country'])[0]

    return row

def main(environment):
    centroid_lookup = pandas.read_csv(environment.country_centroid_lookup_table, sep='\t')
    centroid_lookup = { i['FIPS10'] : (i['LONG'], i['LAT']) for i in centroid_lookup.to_dict(orient='records')}
    agol_token = agol.generate_token(environment.agol_user, environment.agol_pass)
    df = get_parse_content(environment.parse_data_endpoint)
    # df = get_parse_content(environment.arcgis_source_file)
    df = df.where((pandas.notnull(df)), None)  # - nan to None
    clean_row_func = partial(clean_row, centroid_lookup)
    df = df.apply(clean_row_func, axis=1)
    df = df[df.latitude.notnull() & df.longitude.notnull()]
    output_problem_rows(df)

    for c in [c for c, t in zip(df.columns, df.dtypes) if t == 'object']:
        if len(df[df[c].str.len() > environment.max_character_limit]) > 0:
            df[c] = df[c].map(lambda r: r and r[:environment.max_character_limit] or r)

    print "Updating %s environment schema %s for account %s" % (env.environment, env.agol_feature_service_url, env.agol_user)
    refresh_agol(df, environment.agol_feature_service_url, token=agol_token)
    # print "skipping refresh_agol"
    # print df['org_name']
    return env.environment + " has been successfully updated."

if __name__ == '__main__':

    if len(sys.argv) > 1 and sys.argv[1] == 'build_schema':
        create_schema_file(sys.argv[2], sys.argv[3])
        sys.exit(0)
    from settings import env
    #agol_token = agol.generate_token(env.agol_user, env.agol_pass)
    #agol.delete_features(env.agol_feature_service_url, where='objectid > 0', token=agol_token)
    main(env)

