Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/trusty64"

  config.vm.provider :virtualbox do |vb|
    vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    vb.gui = false
    vb.memory = "1024"
  end

  config.vm.provision "default", type: "shell", :path => "config/vagrant/provision.sh"
  config.vm.provision "rabbit", type: "shell", :path => "config/vagrant/provision_rabbit.sh", run: "always"

  config.vm.define :default, primary: true do |default_config|
    default_config.vm.network :forwarded_port, guest: 80, host: 80, host_ip: "127.0.0.1"
    default_config.vm.network :forwarded_port, guest: 443, host: 443, host_ip: "127.0.0.1"
    default_config.vm.network :forwarded_port, guest: 3306, host: 3306, host_ip: "127.0.0.1"

    # RabbitMQ
    default_config.vm.network :forwarded_port, guest: 15672, host: 15672, host_ip: "127.0.0.1"
    default_config.vm.network :forwarded_port, guest: 5672, host: 5672, host_ip: "127.0.0.1"
  end

  config.vm.synced_folder "./public", "/var/www/sites/public", create: true, group: "www-data", owner: "www-data", id: 'sites-public'
  config.vm.synced_folder "./src", "/var/www/sites/src", create: true, group: "www-data", owner: "www-data", id: 'sites-src'
  config.vm.synced_folder "./vendor", "/var/www/sites/vendor", create: true, group: "www-data", owner: "www-data", id: 'sites-vendor'
  config.vm.synced_folder "./config", "/var/www/scripts/config", create: true, group: "www-data", owner: "www-data", id: 'init-scripts'
end
