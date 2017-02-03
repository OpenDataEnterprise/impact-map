# Open Data Impact Map
Version 2.0

This is the first centralized, searchable database of open data use cases from around the world. Your contribution makes it possible to better understand the value of open data and encourage its use globally. Information collected will be displayed on http://www.opendataimpactmap.org and will be made available as open data.

# Requirements (you need to install these applications on your computer before you start setting up)

- Virtualbox
- Vagrant
- Ansible

# Quickstart

1. Launch the virtual machine to get the CentOS environment
```
cd odesurvey
cd vm/basic
vagrant up
```

If there's a problem of "mounting the shared folder", that might be due to the lack of Apache on the Vagrant machine. Try to run `vagrant provision` to run the Ansible scripts to install Apache first. Then, halt and start the Vagrant machine one more time. 
```
vagrant provision 	# provision the script so Ansible scripts run
vagrant halt  		# halt the machine
vagrant up 	  		# turn on the machine again
```

1. Open browser and go to location `http://192.168.56.101`

If the URL does not work, check `vm/basic/Vagrantfile` and check Vagrantfile configurations for the exact URL.

# Possible Bugs
1. When you go to `http://192.168.56.101` and there is an error (i.e., not loading the index.html page with http 500 error), copy Apache configuration files from `/var/templates/` to `/etc/httpd/` for each folder (don't copy entire folders, but just files.) inside the Vagrant machine.
```
vagrant ssh
sudo cp /var/templates/etc/httpd/conf/* /etc/httpd/conf/
sudo cp /var/templates/etc/httpd/conf.d/* /etc/httpd/conf.d/
```

2. Ansible issue on Windows machines
It's possible that Ansible scripts are not running on Windows machines due to the compatibility issue. In this case, you need to install required software such as MySQL, PHP, Apache, and Python by yourself. Note that Ansible is running with Python 2.x.

# References/Links

## General
1. [UN Locodes](http://www.unece.org/cefact/locode/welcome.html)
1. [UN Locodes subdivisions](http://www.unece.org/cefact/locode/subdivisions.html)
1. [Locodes stack overflow](http://stackoverflow.com/questions/7066825/is-there-an-iso-standard-for-city-identification)
1. [GSMAIntelligence](https://gsmaintelligence.com)

## Snippets
1. [x-editable demo.js see validate](http://vitalets.github.io/x-editable/assets/demo.js)
1. [x-editable mock ajax and console](http://vitalets.github.io/x-editable/assets/demo-mock.js)

# Credits
### Version 2
- Project Management: Audrey Ariss
- Technical Lead: Myeong Lee
- Development: Noah Song, Myeong Lee, Vinayak Pande, and Pooja Singh 
- Contents: Laura Manley and Audrey Ariss 
- Design: ThreeSpot.com

### Version 1
- Impact Map: Greg Elin (GovReady.com), Sumiko Carter, ThreeSpot.com, Myeong Lee, and BlueRaster

# Resources
- Using ArcGIS Online
- Using SlimPHP Framework
- Using MySQL Database
- Using jQuery Bootgrid - http://www.jquery-bootgrid.com
- Ubilabs geocomplete - http://ubilabs.github.io/geocomplete/
