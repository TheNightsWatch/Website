# == Class: mysql
#
# Performs initial configuration tasks for all Vagrant boxes.
#
class mysql {
  package { ['mysql-community-server']:
    ensure => latest;
  }

  service { 'mysql':
    ensure  => running,
    require => Package['mysql-community-server'];
  }

  file { '/etc/mysql/mysql.conf.d/open-access.cnf':
    source  => 'puppet:///modules/mysql/open-access.cnf',
    require => Package['mysql-community-server'],
    notify  => Service['mysql'];
  }

  exec { 'refresh-mysql-user':
    command => 'mysql -uroot -proot -e "DROP USER \'root\'@\'localhost\';GRANT ALL ON *.* to root@\'%\' IDENTIFIED BY \'root\'; FLUSH PRIVILEGES";touch /etc/mysql/user-refreshed',
    creates => '/etc/mysql/user-refreshed',
    path => ['/bin', '/usr/bin'],
    require => Service['mysql'];
  }
}
