# == Class: baseconfig
#
# Performs initial configuration tasks for all Vagrant boxes.
#
class composer {
  package { ['curl']:
    ensure => present;
  }

  exec { 'install composer':
    creates => '/usr/local/bin/composer',
    command => '/usr/bin/curl -sS https://getcomposer.org/installer | /usr/bin/sudo -H /usr/bin/php -- --install-dir=/usr/local/bin --filename=composer',
    require => [Package['php7.0'], Package['php7.0-curl'], Package['curl']];
  }

  exec { 'install prestissimo':
    creates     => '/home/vagrant/.config/composer/vendor/hirak',
    command     => '/usr/local/bin/composer global require hirak/prestissimo',
    require     => [Exec['install composer'], Package['git']],
    user        => 'vagrant',
    environment => ['HOME=/home/vagrant'],
  }
}
