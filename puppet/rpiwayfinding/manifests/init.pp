$webserver = 'wayfinding'


class rpiwayfinding::sign {

    package { "feh":
        ensure => latest
    }

    file { "/home/pi/rpi-wayfinding.sh":
        owner   => pi,
        group   => pi,
        mode    => 755,
        content  => template("rpiwayfinding/rpi-wayfinding.erb"),
        require => Package["feh"];

	"/home/pi/.config/autostart":
		ensure => directory;

	"/home/pi/.config/autostart/rpi-wayfinding.desktop":
        owner   => pi,
        group   => pi,
        mode    => 755,
        source  => "puppet:///modules/rpiwayfinding/rpi-wayfinding.desktop",
        require => Package["feh"];
    
	"/home/pi/.config/autostart/noscreensaver.desktop":
        owner   => pi,
        group   => pi,
        mode    => 755,
        source  => "puppet:///modules/rpiwayfinding/noscreensaver.desktop",
        require => Package["feh"];
    
	"/home/pi/noscreensaver.sh":
        owner   => pi,
        group   => pi,
        mode    => 755,
        source  => "puppet:///modules/rpiwayfinding/noscreensaver.sh",
        require => Package["feh"];
    }



}
$area = '1st_floor'

class rpiwayfinding::group {

    package { "feh":
        ensure => latest
    }

    file { "/home/pi/rpi-wayfinding.sh":
        owner   => pi,
        group   => pi,
        mode    => 755,
        content  => template("rpiwayfinding/rpi-wayfinding-group.erb"),
        require => Package["feh"];

	"/home/pi/.config/autostart":
        ensure => directory;

	"/home/pi/.config/autostart/rpi-wayfinding.desktop":
        owner   => pi,
        group   => pi,
        mode    => 755,
        source  => "puppet:///modules/rpiwayfinding/rpi-wayfinding.desktop",
        require => Package["feh"];

	"/home/pi/.config/autostart/noscreensaver.desktop":
        owner   => pi,
        group   => pi,
        mode    => 755,
        source  => "puppet:///modules/rpiwayfinding/noscreensaver.desktop",
        require => Package["feh"];
    
	"/home/pi/noscreensaver.sh":
        owner   => pi,
        group   => pi,
        mode    => 755,
        source  => "puppet:///modules/rpiwayfinding/noscreensaver.sh",
        require => Package["feh"];
    }


}

$bldg = 'administration'
class rpiwayfinding::bldg {

    package { "feh":
        ensure => latest
    }

    file { "/home/pi/rpi-wayfinding.sh":
        owner   => pi,
        group   => pi,
        mode    => 755,
        content  => template("rpiwayfinding/rpi-wayfinding-bldg.erb"),
        require => Package["feh"];
    
	"/home/pi/.config/autostart":
        ensure => directory;

	"/home/pi/.config/autostart/rpi-wayfinding.desktop":
        owner   => pi,
        group   => pi,
        mode    => 755,
        source  => "puppet:///modules/rpiwayfinding/rpi-wayfinding.desktop",
        require => Package["feh"];

	"/home/pi/.config/autostart/noscreensaver.desktop":
        owner   => pi,
        group   => pi,
        mode    => 755,
        source  => "puppet:///modules/rpiwayfinding/noscreensaver.desktop",
        require => Package["feh"];
    
	"/home/pi/noscreensaver.sh":
        owner   => pi,
        group   => pi,
        mode    => 755,
        source  => "puppet:///modules/rpiwayfinding/noscreensaver.sh",
        require => Package["feh"];
    }

}




