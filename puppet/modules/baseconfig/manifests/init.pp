# == Class: baseconfig
#
# Performs initial configuration tasks for all Vagrant boxes.
#
class baseconfig {
  file { '/var/tmp/varnishgpg':
    source => 'puppet:///modules/baseconfig/Varnish-GPG',
  }

  file { '/var/tmp/mysqlgpg':
    source => 'puppet:///modules/baseconfig/MySQL-GPG',
  }

  file { '/etc/apt/sources.list.d/varnish-cache.list':
    content => 'deb https://repo.varnish-cache.org/ubuntu/ trusty varnish-4.0',
    before => Exec['apt-get update'],
  }

  file { '/etc/apt/sources.list.d/mysql.list':
    content => 'deb http://repo.mysql.com/apt/ubuntu/ trusty mysql-5.7',
    before => Exec['apt-get update'],
  }

  exec { 'Load Varnish GPG':
    command => '/bin/cat /var/tmp/varnishgpg | /usr/bin/apt-key add -',
    require => [File['/var/tmp/varnishgpg'], File['/etc/apt/sources.list.d/varnish-cache.list']],
    before => Exec['apt-get update'];
  }

  exec { 'Load MySQL GPG':
    command => '/bin/cat /var/tmp/mysqlgpg | /usr/bin/apt-key add -',
    require => [File['/var/tmp/varnishgpg'], File['/etc/apt/sources.list.d/mysql.list']],
    before => Exec['apt-get update'];
  }

  exec { 'Adding PHP repository':
    command => '/usr/bin/add-apt-repository ppa:ondrej/php',
    unless  => '/bin/grep -q "ondrej/php" /etc/apt/sources.list /etc/apt/sources.list.d/*',
    before  => Exec['apt-get update'];
  }

  exec { 'apt-get update':
    command => '/usr/bin/apt-get update -q',
  }

  package { ['dos2unix']:
    ensure  => present,
    require => Exec['apt-get update'],
  }

  host { 'hostmachine':
    ip => '192.168.0.1';
  }

  file {
    '/home/vagrant/.bashrc':
      owner  => 'vagrant',
      group  => 'vagrant',
      mode   => '0644',
      source => 'puppet:///modules/baseconfig/bashrc';
  }

  file {
    '/home/vagrant/.bash_profile':
      owner  => 'vagrant',
      group  => 'vagrant',
      mode   => '0644',
      source => 'puppet:///modules/baseconfig/bash_profile';
  }

}
