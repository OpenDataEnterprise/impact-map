Managing the Map Visualization and Data on ArcGIS Online
========================================================


## Update the Map Visualization (Publishing profiles to ArcGIS Online)
1. Opening a terminal
2. Navagating to the directory with the `agol_integration.py` script
3. Running bash script
4. Checking output

#### Example terminal session of these steps:

```
# navigate to repository
cd /path/projects/impact-map

# download the most up-to-date scripts (just in case)
git pull origin master

# navigate to directory with agol_integration.py script
cd scripts/agol-integration/

# Run migrate.sh (this file is available from developers or administrators, not available in the repo)
bash migrate.sh                 # for development map update
bash migrate.sh production      # for production map update

```

## Possible Bugs

1. Bash error
If there is an error when running `migrate.sh`, it's possible due to the line-ending issue. For example, Windows saves files with its own line endings and it's not working on Macs or in the Bash command line. So if this happens, open `migrate.sh` in one of your editor such as Sublime Text, and change the line endings into Unix (from Windows).
2. ArcGIS update error
If you receive an error while uploading data, run the script one more time. It is possible that the script is disconnected from ArcGIS if there are too many data. If the error occurs continusouly after 2 to 3 times of running the script, contact the administrator. 