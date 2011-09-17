### Allowing www-data to restart the DHCP server
Apache (www-data) needs to restart the dhcp-server when an user creates a new
SIP phone or edits the mac adress of an existing one. You have to add www-data
to the sudoers file in order to allow this without any passwort prompt.
You edit the sudoers file by executing (don't edit the file manually!):
 
    sudo visudo

And you should add the line
    www-data hekphone  = NOPASSWD: /etc/init.d/dhcp3-server, /usr/sbin/dhcpd3
    
This is it. Everytime the phones form is saved the task hekphone:create-dhcp-…
is executed and by this the changes are immediately applied.