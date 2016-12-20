# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  config.vm.provider "virtualbox" do |v|
    v.memory = 1024
    v.cpus = 2
  end
  config.vm.box = "ubuntu/trusty64"
  config.vm.synced_folder "./", "/vagrant", id: "vagrant-root", :group=>'www-data', :mount_options=>['dmode=775,fmode=775']
  config.vm.provision :shell, path: "bootstrap.sh"
  config.vm.network "private_network", ip: "192.168.10.11"
  config.vm.network :forwarded_port, guest: 80, host: 8018
end