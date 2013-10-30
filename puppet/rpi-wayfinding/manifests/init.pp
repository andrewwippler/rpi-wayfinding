class rpi-wayfinding {

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
        source  => "puppet:///modules/rpi-wayfinding/rpi-wayfinding.desktop",
        require => Package["feh"],
    }

    file { "/home/pi/rpi-wayfinding.sh":
        owner   => root,
        group   => root,
        mode    => 644,
        content  => template("rpi-wayfinding/rpi-wayfinding.erb"),
        require => Package["feh"],
    }

}




