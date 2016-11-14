# Updating website

Below is the sequence of terminal commands to update a server
```
# ssh (e.g., login) to remote server 
ssh root@odetest.opendataenterprise.org

# switch user to gregelin
su gregelin

# change directory to home directory for user gregelin
cd ~/

# change to local copy of odesurvey repo
cd odesurvey

# git pull most recent version of site
git pull

# copy updated files into /var/www/html 
sudo cp -R html /var/www/

# update file permissions
sudo chmod -R 755 /var/www/html

# web sites updated have been published.

# Log out of gregelin user and remote session
exit
exit
```


Below is an example terminal session updating the website
```
Gregs-MBP:basic greg$ # ssh (e.g., login) to remote server 
Gregs-MBP:basic greg$ 
Gregs-MBP:basic greg$ ssh root@odetest.opendataenterprise.org
Last login: Mon Jul 13 19:43:04 2015 from xxxxxxxx.washdc.fios.verizon.net
[root@odesurvey-staging2 ~]# 
[root@odesurvey-staging2 ~]# # switch user to gregelin
[root@odesurvey-staging2 ~]# su gregelin
[gregelin@odesurvey-staging2 root]$ 
[gregelin@odesurvey-staging2 root]$ # change directory to home directory for user gregelin
[gregelin@odesurvey-staging2 root]$ 
[gregelin@odesurvey-staging2 root]$ cd ~/
[gregelin@odesurvey-staging2 ~]$ 
[gregelin@odesurvey-staging2 ~]$ # change to local copy of odesurvey repo
[gregelin@odesurvey-staging2 ~]$ 
[gregelin@odesurvey-staging2 ~]$ cd odesurvey
[gregelin@odesurvey-staging2 odesurvey]$ 
[gregelin@odesurvey-staging2 odesurvey]$ # git pull most recent version of site
[gregelin@odesurvey-staging2 odesurvey]$ 
[gregelin@odesurvey-staging2 odesurvey]$ git pull
Enter passphrase for key '/home/gregelin/.ssh/id_rsa': 
remote: Counting objects: 30, done.
remote: Compressing objects: 100% (29/29), done.
remote: Total 30 (delta 7), reused 0 (delta 0), pack-reused 0
Unpacking objects: 100% (30/30), done.
From github.com:GovReady/odesurvey
   5875a3e..071729f  master     -> origin/master
Updating 5875a3e..071729f
Fast-forward
 .gitignore                                         |    5 +
 .../survey/Locale/de_DE/LC_MESSAGES/messages.mo    |  Bin 0 -> 8777 bytes
 .../survey/Locale/de_DE/LC_MESSAGES/messages.po    |  266 +-
 html/map/survey/templates/survey/tp_survey.php     |   14 +-
 .../survey/templates/survey/tp_survey_gettext.php  |   22 +-
 .../agol_integration/agol_integration.py           |    4 +-
 .../agol-integration/agol_integration/settings.py  |   15 +-
 .../agol-integration/agol_service_schema_fix.json  |  642 +
 scripts/agol-integration/arcgis_flatfile.0528.json |96495 ++++++++++++++++++
 .../agol-integration/arcgis_flatfile.706.0528.json |96495 ++++++++++++++++++
 .../arcgis_flatfile.brendan0527.json               |95696 ++++++++++++++++++
 .../agol-integration/arcgis_flatfile.json.old.json |102887 ++++++++++++++++++++
 scripts/agol-integration/arcgis_schema_jul04.csv   |    3 +
 scripts/agol-integration/farms_canada.json         |  491 +
 14 files changed, 392883 insertions(+), 152 deletions(-)
 create mode 100644 html/map/survey/Locale/de_DE/LC_MESSAGES/messages.mo
 create mode 100644 scripts/agol-integration/agol_service_schema_fix.json
 create mode 100644 scripts/agol-integration/arcgis_flatfile.0528.json
 create mode 100644 scripts/agol-integration/arcgis_flatfile.706.0528.json
 create mode 100644 scripts/agol-integration/arcgis_flatfile.brendan0527.json
 create mode 100644 scripts/agol-integration/arcgis_flatfile.json.old.json
 create mode 100644 scripts/agol-integration/arcgis_schema_jul04.csv
 create mode 100644 scripts/agol-integration/farms_canada.json
[gregelin@odesurvey-staging2 odesurvey]$ 
[gregelin@odesurvey-staging2 odesurvey]$ 
[gregelin@odesurvey-staging2 odesurvey]$ # copy updated files into /var/www/html 
[gregelin@odesurvey-staging2 odesurvey]$ 
[gregelin@odesurvey-staging2 odesurvey]$ sudo cp -R html /var/www/
[sudo] password for gregelin: 
[gregelin@odesurvey-staging2 odesurvey]$ 
[gregelin@odesurvey-staging2 odesurvey]$ # update file permissions
[gregelin@odesurvey-staging2 odesurvey]$ 
[gregelin@odesurvey-staging2 odesurvey]$ sudo chmod -R 755 /var/www/html
[gregelin@odesurvey-staging2 odesurvey]$ 
[gregelin@odesurvey-staging2 odesurvey]$ # web sites updated have been published.
[gregelin@odesurvey-staging2 odesurvey]$ 
```