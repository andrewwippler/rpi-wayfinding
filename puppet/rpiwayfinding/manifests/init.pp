    # Definition: rpiwayfinding
    #
    # This class installs RPi-Wayfinding Hosts
    #
    # Parameters:
    # - The $webserver is where you want this device to point to
    # - The $group is the floor level
    # - The $bldg is all of the events in that location
    #
    # Actions:
    # - Sets up a Feh script on the host
    #
    #
    # Sample Usage:
    #  rpiwayfinding { 'sign-name':
    #    webserver => 'rpiwayfinding.domain.tld',
    #  }
    #
    #  rpiwayfinding { 'sign-name':
    #    template => 'bldg',
    #    bldg => 'new',
    #  }
    #

define rpiwayfinding (
$webserver = 'wayfinding',
$group = 'first-floor',
$bldg = 'admin',
$template = 'sign',
) {

    package { "feh":
        ensure => latest,
    }

    file { "/home/pi/rpi-wayfinding.sh":
        owner   => pi,
        group   => pi,
        mode    => 755,
        content  => template("rpiwayfinding/rpi-wayfinding-${template}.erb"),
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


