# == Class: baseconfig
#
# Performs initial configuration tasks for all Vagrant boxes.
#
class php {
  package { ['php7.0', 'php7.0-bcmath', 'php7.0-mcrypt', 'php7.0-curl', 'php7.0-cli', 'php7.0-mysql', 'php7.0-gd', 'php7.0-intl', 'php7.0-xsl', 'php-xdebug', 'php7.0-mbstring', 'php7.0-zip']:
    ensure => present,
    notify => Service['apache2'];
  }

  php::module{ ['20-xdebug.ini']: }
}
