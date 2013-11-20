class rpiwayfinding::sign {

$webserver = "asa"

    package { "feh":
        ensure => latest
    }


	# run exec only if command in onlyif returns 0.
    exec { "mkdir_autostart":
        command => "mkdir /home/pi/.config/autostart",
        onlyif => "[ ! -d /home/pi/.config/autostart ]",
    }

    file { "/home/pi/.config/autostart/rpi-wayfinding.desktop":
        owner   => root,
        group   => root,
        mode    => 644,
        source  => "puppet:///modules/rpiwayfinding/rpi-wayfinding.desktop",
        require => Package["feh"],
    }

    file { "/home/pi/rpi-wayfinding.sh":
        owner   => root,
        group   => root,
        mode    => 644,
        content  => template("rpiwayfinding/rpi-wayfinding.erb"),
        require => Package["feh"],
    }

}

class rpiwayfinding::group {

$webserver = "asa"
$area = "1st_floor" # must match $r['group']

    package { "feh":
        ensure => latest
    }


	# run exec only if command in onlyif returns 0.
    exec { "mkdir_autostart":
        command => "mkdir /home/pi/.config/autostart",
        onlyif => "[ ! -d /home/pi/.config/autostart ]",
    }

    file { "/home/pi/.config/autostart/rpi-wayfinding.desktop":
        owner   => root,
        group   => root,
        mode    => 644,
        source  => "puppet:///modules/rpiwayfinding/rpi-wayfinding.desktop",
        require => Package["feh"],
    }

    file { "/home/pi/rpi-wayfinding.sh":
        owner   => root,
        group   => root,
        mode    => 644,
        content  => template("rpiwayfinding/rpi-wayfinding-group.erb"),
        require => Package["feh"],
    }

}

class rpiwayfinding::bldg {

$webserver = "asa"
$bldg = "administration" # must match $r['bldg']

    package { "feh":
        ensure => latest
    }


	# run exec only if command in onlyif returns 0.
    exec { "mkdir_autostart":
        command => "mkdir /home/pi/.config/autostart",
        onlyif => "[ ! -d /home/pi/.config/autostart ]",
    }

    file { "/home/pi/.config/autostart/rpi-wayfinding.desktop":
        owner   => root,
        group   => root,
        mode    => 644,
        source  => "puppet:///modules/rpiwayfinding/rpi-wayfinding.desktop",
        require => Package["feh"],
    }

    file { "/home/pi/rpi-wayfinding.sh":
        owner   => root,
        group   => root,
        mode    => 644,
        content  => template("rpiwayfinding/rpi-wayfinding-bldg.erb"),
        require => Package["feh"],
    }

}




