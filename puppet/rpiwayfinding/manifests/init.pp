class rpiwayfinding::sign {

$webserver = "wayfinding"

    package { "feh":
        ensure => latest
    }

    file { "/home/pi/rpi-wayfinding.sh":
        owner   => root,
        group   => root,
        mode    => 755,
        content  => template("rpiwayfinding/rpi-wayfinding.erb"),
        require => Package["feh"],
    }

	# run exec only if command in onlyif returns 0.
    exec { "mkdir_autostart_rpi":
        command => "/bin/mkdir -p /home/pi/.config/autostart",
        onlyif => "/usr/bin/test ! -d /home/pi/.config/autostart"
    }

    file { "/home/pi/.config/autostart/rpi-wayfinding.desktop":
        owner   => root,
        group   => root,
        mode    => 644,
        source  => "puppet:///modules/rpiwayfinding/rpi-wayfinding.desktop",
        require => Package["feh"],
    }
    
    file { "/home/pi/.config/autostart/noscreensaver.desktop":
        owner   => root,
        group   => root,
        mode    => 644,
        source  => "puppet:///modules/rpiwayfinding/noscreensaver.desktop",
        require => Package["feh"],
    }
    
        file { "/home/pi/noscreensaver.sh":
        owner   => root,
        group   => root,
        mode    => 755,
        source  => "puppet:///modules/rpiwayfinding/noscreensaver.sh",
        require => Package["feh"],
    }



}

class rpiwayfinding::group {

$webserver = "wayfining"
$area = "1st_floor" # must match $r['group']

    package { "feh":
        ensure => latest
    }

    file { "/home/pi/rpi-wayfinding.sh":
        owner   => root,
        group   => root,
        mode    => 755,
        content  => template("rpiwayfinding/rpi-wayfinding-group.erb"),
        require => Package["feh"],
    }

	# run exec only if command in onlyif returns 0.
    exec { "mkdir_autostart_rpi":
        command => "/bin/mkdir -p /home/pi/.config/autostart",
        onlyif => "/usr/bin/test ! -d /home/pi/.config/autostart"
    }

    file { "/home/pi/.config/autostart/rpi-wayfinding.desktop":
        owner   => root,
        group   => root,
        mode    => 644,
        source  => "puppet:///modules/rpiwayfinding/rpi-wayfinding.desktop",
        require => Package["feh"],
    }

    file { "/home/pi/.config/autostart/noscreensaver.desktop":
        owner   => root,
        group   => root,
        mode    => 644,
        source  => "puppet:///modules/rpiwayfinding/noscreensaver.desktop",
        require => Package["feh"],
    }
    
        file { "/home/pi/noscreensaver.sh":
        owner   => root,
        group   => root,
        mode    => 755,
        source  => "puppet:///modules/rpiwayfinding/noscreensaver.sh",
        require => Package["feh"],
    }


}

class rpiwayfinding::bldg {

$webserver = "wayfinding"
$bldg = "administration" # must match $r['bldg']

    package { "feh":
        ensure => latest
    }

    file { "/home/pi/rpi-wayfinding.sh":
        owner   => root,
        group   => root,
        mode    => 755,
        content  => template("rpiwayfinding/rpi-wayfinding-bldg.erb"),
        require => Package["feh"],
    }

	# run exec only if command in onlyif returns 0.
    exec { "mkdir_autostart_rpi":
        command => "/bin/mkdir -p /home/pi/.config/autostart",
        onlyif => "/usr/bin/test ! -d /home/pi/.config/autostart"
    }

    file { "/home/pi/.config/autostart/rpi-wayfinding.desktop":
        owner   => root,
        group   => root,
        mode    => 644,
        source  => "puppet:///modules/rpiwayfinding/rpi-wayfinding.desktop",
        require => Package["feh"],
    }

    file { "/home/pi/.config/autostart/noscreensaver.desktop":
        owner   => root,
        group   => root,
        mode    => 644,
        source  => "puppet:///modules/rpiwayfinding/noscreensaver.desktop",
        require => Package["feh"],
    }
    
        file { "/home/pi/noscreensaver.sh":
        owner   => root,
        group   => root,
        mode    => 755,
        source  => "puppet:///modules/rpiwayfinding/noscreensaver.sh",
        require => Package["feh"],
    }

}




