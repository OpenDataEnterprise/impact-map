Managing the Map Visualization and Data on ArcGIS Online
========================================================

# Update the Map Visualization (Publishing profiles to ArcGIS Online)

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

##NOTE
If you receive an error, run the script one more time. It is possible that the script is disconnected from ArcGIS if there are many data. If the error occurs continusouly after 2 to 3 times of running the script, contact the administrator. 