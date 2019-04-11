#!/usr/bin/env python

# Usage
#   AGOL_USER=<username>
#   export AGOL_USER
#   AGOL_PASS=<password>
#   export AGOL_PASS
#   AGOL_ENV=<development | staging | production>
#   export AGOL_ENV
#   python agol_integration.py

from functools import partial
import json
import pdb
import sys
import urllib
import pandas
import agol


def get_json_content(json_file):
    print('Parsing data from JSON file {}'.format(json_file))

    if json_file.find('http') > -1:
        content_response = json.loads(urllib.request.urlopen(json_file).read())
        print('JSON record size: {}'.format(len(content_response['results'])))
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

    print('Found {} problematic records: '.format(len(df_problems)))


def refresh_layer(env, source_df, token):
    features = agol.dataframe_to_point_features(source_df, x_field='longitude', y_field='latitude', wkid=4326)

    agol.truncate_layer(env.feature_service_url, token=token)

    successes, errors = agol.add_features(env.feature_service_url, features, token=token)
    
    with open('agol_success.json', 'w') as success_file:
        if successes:
            print('Number of features written to AGOL: {}'.format(
                len(successes)))
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


def main(env):
    centroid_lookup = pandas.read_csv(env.country_centroid_lookup_table, sep='\t')
    centroid_lookup = { i['FIPS10'] : (i['LONG'], i['LAT']) for i in centroid_lookup.to_dict(orient='records')}

    agol_token = agol.generate_token(env.agol_user, env.agol_pass)

    df = get_json_content(env.json_data_endpoint)
    df = df.where((pandas.notnull(df)), None)  # - nan to None
    clean_row_func = partial(clean_row, centroid_lookup)
    df = df.apply(clean_row_func, axis=1)
    df = df[df.latitude.notnull() & df.longitude.notnull()]
    output_problem_rows(df)

    for c in [c for c, t in zip(df.columns, df.dtypes) if t == 'object']:
        if len(df[df[c].str.len() > env.max_character_limit]) > 0:
            df[c] = df[c].map(lambda r: r and r[:env.max_character_limit] or r)

    print('Updating {} environment schema {} for account {}'.format(env.environment, env.feature_service_url, env.agol_user))

    refresh_layer(env, df, agol_token)

    return env.environment + '{} has been successfully updated.'


if __name__ == '__main__':
    if len(sys.argv) > 1 and sys.argv[1] == 'build_schema':
        create_schema_file(sys.argv[2], sys.argv[3])
        sys.exit(0)
    from settings import env
    main(env)
