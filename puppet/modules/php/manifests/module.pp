# == Define: module
#
# Adds php module file.
#
define php::module () {
  file { "/etc/php/7.0/apache2/conf.d/${name}":
    ensure  => present,
    source  => "puppet:///modules/php/${name}",
    require => [Package['apache2'], Package['php-xdebug'], Package['php7.0']],
    notify  => Service['apache2'];
  }
  file { "/etc/php/7.0/cli/conf.d/${name}":
    ensure  => present,
    source  => "puppet:///modules/php/${name}",
    require => [Package['apache2'], Package['php7.0']],
    notify  => Service['apache2'];
  }
}
