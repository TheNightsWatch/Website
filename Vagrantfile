# -*- mode: ruby -*-
# vi: set ft=ruby :

ram      = '4000'
cpus     = '4'

box      = 'ubuntu/trusty64'
domain   = 'local-minez-nightswatch.com'
hostname = domain
ip       = '192.168.57.105'

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

unless Vagrant.has_plugin?("vagrant-hostmanager")
  raise 'Missing required plugin.  Run "vagrant plugin install vagrant-hostmanager"'
end

unless Vagrant.has_plugin?("vagrant-winnfsd")
    raise 'Missing required plugin.  Run "vagrant plugin install vagrant-winnfsd"'
end

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.box = box
  config.vm.hostname = hostname
  config.vm.network "private_network", ip: ip

  config.hostmanager.enabled = true
  config.hostmanager.manage_host = true

  config.vm.provider "virtualbox" do |v|
    v.customize ['modifyvm', :id, '--name', hostname, '--memory', ram, "--ioapic", "on", "--cpus", cpus]
    v.customize ["setextradata", :id, "VBoxInternal2/SharedFoldersEnableSymlinksCreate/v-root", "1"]
  end

  config.vm.synced_folder "./", "/var/www/thenightswatch", type: "nfs"

  config.vm.provision :puppet do |puppet|
    puppet.manifests_path = 'puppet/manifests'
    puppet.manifest_file = 'site.pp'
    puppet.module_path = 'puppet/modules'
    puppet.facter = {
        'hostname' => hostname
    }
  end

end
