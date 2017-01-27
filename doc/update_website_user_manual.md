# Updating website

Below is the sequence of terminal commands to update a server
```
# ssh (e.g., login) to remote server. To have access to the server, you need to talk to admin users.
# for test server
ssh ubuntu@ec2-54-210-82-88.compute-1.amazonaws.com 

# for production server
ssh ubuntu@opendataimpactmap.org

# change to local copy of impact-map repo
cd impact-map

# git pull most recent version of site
git pull origin master

# copy updated files into /var/www/html 
sudo cp -R html /var/www/

# web sites updated have been published.

# Log out 
exit
```