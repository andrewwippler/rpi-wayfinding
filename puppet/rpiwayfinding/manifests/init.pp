class rpiwayfinding::sign ($webserver = 'wayfinding') {

    package { "feh":
        ensure => latest
    }

    file { "/home/pi/rpi-wayfinding.sh":
        owner   => root,
        group   => root,
        mode    => 755,
        content  => template("rpiwayfinding/rpi-wayfinding.erb"),
        require => Package["feh"];

	"/home/pi/.config/autostart":
		ensure => directory;

	"/home/pi/.config/autostart/rpi-wayfinding.desktop":
        owner   => root,
        group   => root,
        mode    => 644,
        source  => "puppet:///modules/rpiwayfinding/rpi-wayfinding.desktop",
        require => Package["feh"];
    
	"/home/pi/.config/autostart/noscreensaver.desktop":
        owner   => root,
        group   => root,
        mode    => 644,
        source  => "puppet:///modules/rpiwayfinding/noscreensaver.desktop",
        require => Package["feh"];
    
	"/home/pi/noscreensaver.sh":
        owner   => root,
        group   => root,
        mode    => 755,
        source  => "puppet:///modules/rpiwayfinding/noscreensaver.sh",
        require => Package["feh"];
    }



}

class rpiwayfinding::group ($webserver = 'wayfinding', $area = '1st_floor') {

    package { "feh":
        ensure => latest
    }

    file { "/home/pi/rpi-wayfinding.sh":
        owner   => root,
        group   => root,
        mode    => 755,
        content  => template("rpiwayfinding/rpi-wayfinding-group.erb"),
        require => Package["feh"];

	"/home/pi/.config/autostart":
        ensure => directory;

	"/home/pi/.config/autostart/rpi-wayfinding.desktop":
        owner   => root,
        group   => root,
        mode    => 644,
        source  => "puppet:///modules/rpiwayfinding/rpi-wayfinding.desktop",
        require => Package["feh"];

	"/home/pi/.config/autostart/noscreensaver.desktop":
        owner   => root,
        group   => root,
        mode    => 644,
        source  => "puppet:///modules/rpiwayfinding/noscreensaver.desktop",
        require => Package["feh"];
    
	"/home/pi/noscreensaver.sh":
        owner   => root,
        group   => root,
        mode    => 755,
        source  => "puppet:///modules/rpiwayfinding/noscreensaver.sh",
        require => Package["feh"];
    }


}

class rpiwayfinding::bldg ($webserver = 'wayfinding', $bldg = 'administration') {

    package { "feh":
        ensure => latest
    }

    file { "/home/pi/rpi-wayfinding.sh":
        owner   => root,
        group   => root,
        mode    => 755,
        content  => template("rpiwayfinding/rpi-wayfinding-bldg.erb"),
        require => Package["feh"];
    
	"/home/pi/.config/autostart":
        ensure => directory;

	"/home/pi/.config/autostart/rpi-wayfinding.desktop":
        owner   => root,
        group   => root,
        mode    => 644,
        source  => "puppet:///modules/rpiwayfinding/rpi-wayfinding.desktop",
        require => Package["feh"];

	"/home/pi/.config/autostart/noscreensaver.desktop":
        owner   => root,
        group   => root,
        mode    => 644,
        source  => "puppet:///modules/rpiwayfinding/noscreensaver.desktop",
        require => Package["feh"];
    
	"/home/pi/noscreensaver.sh":
        owner   => root,
        group   => root,
        mode    => 755,
        source  => "puppet:///modules/rpiwayfinding/noscreensaver.sh",
        require => Package["feh"];
    }

}




