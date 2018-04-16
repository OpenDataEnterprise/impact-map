apt-get update
apt-get -y upgrade

apt-get -y install libselinux1
apt-get -y install policykit-1
apt-get -y install policycoreutils
apt-get -y install gettext
apt-get -y install apache2
apt-get -y install php5
apt-get -y install php5-mcrypt
apt-get -y install php5-pgsql
apt-get -y install php5-gd
apt-get -y install php5-tidy
apt-get -y install php-pear
echo "Apache and PHP installed."