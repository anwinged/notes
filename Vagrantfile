# -*- mode: ruby -*-
# vi: set ft=ruby :

ENV["LC_ALL"] = "en_US.UTF-8"

# For installing ansible_local from pip on guest
Vagrant.require_version ">= 1.8.3"


Vagrant.configure("2") do |config|

  config.vm.box = "ubuntu/xenial64"

  config.vm.provider "virtualbox" do |v|
    v.memory = 1536
    v.cpus = 2
  end

  config.vm.provision "ansible_local" do |ansible|
    ansible.playbook = "ansible/provision.yml"
    ansible.galaxy_role_file = "ansible/requirements.yml"
    ansible.galaxy_roles_path = "ansible/galaxy.roles"
    ansible.sudo = true
  end

  config.vm.network "forwarded_port", guest: 80, host: 8080, auto_correct: true
  config.vm.network "forwarded_port", guest: 3306, host: 33060, auto_correct: true

  # For correct symfony cache and logs writing
  config.vm.synced_folder "./var", "/vagrant/var",
   :owner => 'ubuntu',
   :group => 'www-data',
   :mount_options => ["dmode=775","fmode=666"]

  # For correct session handling
  config.vm.synced_folder "./var/sessions", "/vagrant/var/sessions",
   :owner => 'www-data',
   :group => 'www-data',
   :mount_options => ["dmode=775","fmode=666"]
end
