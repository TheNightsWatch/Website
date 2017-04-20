define apache::website () {
  file { "/etc/apache2/sites-available/${name}":
    source  => "puppet:///modules/apache/${name}",
    require => Package['apache2'],
    notify  => Service['apache2'];
  }

  file { "/etc/apache2/sites-enabled/${name}":
    ensure  => link,
    target  => "/etc/apache2/sites-available/${name}",
    require => Package['apache2'],
    notify  => Service['apache2'];
  }
}
