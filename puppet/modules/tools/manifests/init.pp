class tools {
  file { "/home/vagrant/tools":
    ensure => directory,
  }

  exec { 'Ensure Unix Line-endings for .bashrc':
    require => [File['/home/vagrant/.bashrc'], Package['dos2unix']],
    onlyif  => "/bin/grep $'\r' /home/vagrant/.bashrc",
    user    => 'vagrant',
    command => 'dos2unix -k .bashrc',
    cwd     => '/home/vagrant',
    path    => ['/bin', '/usr/bin'],
  }

  exec { 'Ensure Unix Line-endings for .bash_profile':
    require => [File['/home/vagrant/.bash_profile'], Package['dos2unix']],
    onlyif  => "/bin/grep $'\r' /home/vagrant/.bash_profile",
    user    => 'vagrant',
    command => 'dos2unix -k .bash_profile',
    cwd     => '/home/vagrant',
    path    => ['/bin', '/usr/bin'],
  }
}
