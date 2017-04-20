# == Class: baseconfig
#
# Performs initial configuration tasks for all Vagrant boxes.
#
class apache {
  package { ['apache2']:
    ensure => present;
  }

  service { 'apache2':
    ensure  => running,
    require => Package['apache2'];
  }

  apache::module { ['rewrite.load']: }
  apache::conf { ['apache2.conf', 'ports.conf']: }
  apache::website { ['000-default.conf']: }

  file { '/var/www/html/index.html':
    ensure  => absent,
    require => Package['apache2'];
  }
}
