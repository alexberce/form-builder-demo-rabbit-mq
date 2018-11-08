#!/usr/bin/env bash

echo "  "
echo "Update: system"
add-apt-repository -y ppa:ondrej/php5-5.6
apt-get update
apt-get install -y python-software-properties

apt-get update
apt-get upgrade

# install packages
echo "  "
echo "  "
echo "Install: software packages via apt-get"
apt-get install -y \
apache2 \
php5 \
    php5-curl \
    php5-gd \
    php5-xdebug \
    php5-json \
    php5-mcrypt \
    php5-sqlite \
    php5-memcached \
    php-pear \
memcached \
curl \
wget \
mc \
rabbitmq-server

# enable mcrypt module
php5enmod mcrypt

echo "  "
echo "  "
echo "Install: composer"
curl https://getcomposer.org/installer > /tmp/composer-setup.php
cd /tmp && php ./composer-setup.php && cd /var/www && php /tmp/composer.phar update

# configure apache and php5
echo "  "
echo "  "
echo "Configure: apache, mysql and php"

service apache2 stop
service mysql stop
a2enmod ssl
a2enmod rewrite
a2enmod headers

# configure apache2
cp /var/www/scripts/config/vagrant/etc/apache2/apache2.conf /etc/apache2/apache2.conf
cp /var/www/scripts/config/vagrant/etc/apache2/sites-available/queues.formbuilder.demo.conf /etc/apache2/sites-available/queues.formbuilder.demo.conf
cp /var/www/scripts/config/vagrant/etc/apache2/sites-available/www.formbuilder.demo.conf /etc/apache2/sites-available/www.formbuilder.demo.conf

# configure php5
cp /var/www/scripts/config/vagrant/etc/php5/mods-available/xdebug.ini /etc/php5/mods-available/xdebug.ini
cp /var/www/scripts/config/vagrant/etc/php5/apache2/php.ini /etc/php5/apache2/php.ini
cp /var/www/scripts/config/vagrant/etc/php5/cli/php.ini /etc/php5/cli/php.ini


# change owner on modified files in /etc folder
chown root:root -R /etc/apache2
chown root:root -R /etc/php5

echo "STARTING apache2 SERVICE"

a2dissite 000-default
a2ensite queues.formbuilder.demo
a2ensite www.formbuilder.demo

#RabbitMQ
sudo rabbitmq-plugins enable rabbitmq_management
sudo service rabbitmq-server restart
sudo rabbitmqctl add_user demo demo
sudo rabbitmqctl set_user_tags demo administrator
sudo rabbitmqctl delete_user guest
sudo rabbitmqctl delete_vhost /
sudo rabbitmqctl add_vhost live
sudo rabbitmqctl add_vhost development
sudo rabbitmqctl set_permissions -p live demo ".*" ".*" ".*"
sudo rabbitmqctl set_permissions -p development demo ".*" ".*" ".*"

# update /etc/hosts
echo "update /etc/hosts to point queues.formbuilder.demo to host machine"
cp /var/www/scripts/config/vagrant/etc/hosts /etc/hosts

# setup hostname
echo "queues.formbuilder.demo" > /etc/hostname
hostname queues.formbuilder.demo

# the sendmail is installed after we setup hostname, in order to work fast
apt-get install -y sendmail

# update sendmail configuration to route all mails to host machine on smtp 25, and restart sendmail
cd /etc/mail \
&& cat /var/www/scripts/config/vagrant/etc/mail/smarthost.mc >> /etc/mail/sendmail.mc \
&& make \
&& service sendmail restart

# restart apache2
service apache2 restart

echo " "
echo " "
echo " "
echo " "
echo " "
echo " "
echo "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~"
echo "ENVIRONMENT SUCCESSFULLY INITIALIZED."
echo "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~"
echo ""
echo "SSH:"
echo "    vagrant ssh"
echo " "
echo "APACHE:"
echo "    don't forget to add in your /etc/hosts file the following configuration:"
echo ""
echo "    127.0.0.1 queues.formbuilder.demo"
echo "    127.0.0.1 www.formbuilder.demo"
echo " "
echo "LOG FILES:"
echo "    inside a ssh session, type:"
echo "    tail -f -n 10 /var/log/apache2/error.log"
echo " "
echo "MAILS:"
echo "    you must have installed on your host machine a fake smtp mail agent. For windows install"
echo "    the free application called 'Papercut' from https://papercut.codeplex.com/".
echo "    For Linux: you need to install FakeSMTP, from: https://nilhcem.github.io/FakeSMTP/"
echo " "
echo "VIRTUAL MACHINE:"
echo "    vagrant up"
echo "    vagrant destroy"
echo "    vagrant halt"
echo "    vagrant reload"
echo "    vagrant reload --provision"
echo " "
echo " "
echo "THANK YOU, and HAPPY CODING :)"