class tnw {
  exec { 'Install Composer Dependencies':
    creates     => '/var/www/thenightswatch/vendor/autoload.php',
    cwd         => '/var/www/thenightswatch',
    command     => '/usr/local/bin/composer install',
    user        => 'vagrant',
    environment => ['HOME=/home/vagrant'],
    timeout     => 1800,
    require     => Class['composer']
  }

  exec { 'Create Database':
    unless  => 'echo "SELECT 1;" | mysql -uroot -proot tnw',
    command => 'echo "CREATE DATABASE tnw;" | mysql -uroot -proot',
    require => Class['mysql'],
    path    => ['/bin', '/usr/bin'],
  }

  file { '/var/www/thenightswatch/config/db.php':
    source => 'puppet:///modules/tnw/db.php',
  }
}
