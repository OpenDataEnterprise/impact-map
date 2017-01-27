General Notes
=============

# Timeline

Please take note of the following targets and dates:

May 13: Official launch of the Map

# Map Resources
Country Codes
- http://en.wikipedia.org/wiki/ISO_3166-1

For city level data, you can either use a Placefinder – Esri has one built into ArcGIS Online
- http://www.arcgis.com/home/webmap/viewer.html?useExisting=1 (top right)
- https://developers.arcgis.com/javascript/jssamples/index.html#search
- http://www.geonames.org

# Configuring a remote host using ansible playbook

Note the `,` in the name of server to indicate the information is a list and not reference to an inventory file

```
# Dry run from local machine to remote machine
ansible-playbook -i 'odetest.govready.org,' -u root --check playbook-digitalocean.yml 

# Execute from local machine to remote machine
ansible-playbook -i 'odetest.govready.org,' -u root --check playbook-digitalocean.yml 
```

After configuring server, do the following.
- Create user with github access to repository (e.g., 'gregelin')
- Grant user sudo privileges
- CD into `~/.ssh` and create `rsa_id` key
- Cat and copy `rsa_id.pub` to computer clipboard and add to deploy keys
- Remember to create credentials.inc.php file

# How to use

http://192.168.56.101/survey/opendata/ will taky user to http://192.168.56.101/survey/opendata/start/
will create a record and direct them to survey.

# Links 
- [Final question text](https://docs.google.com/a/odenterprise.org/document/d/1kULpKCE5lIuQ3oWBKzWOYFnGgudKPE3R9xeeix86zrs/edit)
- [Sample data](https://docs.google.com/a/odenterprise.org/spreadsheets/d/1I7rVX0y-ligniOMlFFZG4jYTiOML7DEACk_ARrbExjk/edit#gid=1692297685)

# Snippets

## Mailgun

```
curl -s --user 'api:key-c70b6xxxxxxxxxxxx' \
https://api.mailgun.net/v3/sandboxc1675fc5cc30472ca9bd4af8028cbcdf.mailgun.org/messages \
-F from='Excited User <mailgun@sandboxc1675fc5cc30472ca9bd4af8028cbcdf.mailgun.org>' \
-F to=greg@odenterprise.org \
-F subject='Hello' \
-F text='Testing some Mailgun awesomness!'
```

## ArcGIS Online
```
http://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/find?f=pjson&text=Raleigh, NC, USA
```

### Placefinder

Country Codes
- http://en.wikipedia.org/wiki/ISO_3166-1

For city level data, you can either use a Placefinder – Esri has one built into ArcGIS Online
- http://www.arcgis.com/home/webmap/viewer.html?useExisting=1 (top right)
- https://developers.arcgis.com/javascript/jssamples/index.html#search


# Admin
Administration is still under development.

To create an admin account, fill out user information inside `html/map/survey/signup.php` script and call from browser. This will create a proper account in Parse database with encrypted password.

# Using ArcGIS Online Web Interface to Manage Features

## Example update

### Docs
http://resources.arcgis.com/en/help/arcgis-rest-api and navigate to `Your own services` > `Feature Service` > `Update Features`

### Example
https://services5.arcgis.com/[appid]/ArcGIS/rest/services/ode_organizations_staging/FeatureServer/0/updateFeatures

Enter the following into field for `features`
[
    {
      "attributes" : {
      "FID": 12242,
        "org_name" : "Farm Canada XX"
      }
    }
]

Use the `FID` (Feature ID) as the `objectid`. To obtain the `FID`, run a query at url
https://services5.arcgis.com/[appid]/ArcGIS/rest/services/ode_organizations_staging/FeatureServer/0/query


# Miscellaneous Working Notes



