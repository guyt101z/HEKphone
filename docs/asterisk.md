# Asterisk
We're using asterisk 1.6.2.0 on a Ubuntu server (Ubuntu because Debian did not yet have
asterisk 1.6 when the system was set up).


### Installing Asterisk


### Setting up DAHDI to work with two TE110P and one HFC-ISDN card


### Digit files
The Ubuntu asterisk package (1:1.6.2.0~rc2-0ubuntu1.2) has a flaw that puts 
sudo mkdir /usr/share/asterisk/sounds/de/digits/ && sudo cp /usr/share/asterisk/sounds/digits/de/* /usr/share/asterisk/sounds/de/digits/


### File permissions
#### Problem
Asterisk (user: asterisk) and Apache (user: www-data) need to 
access and modify the voicemail messages in */var/spool/voicemail/default/*.
#### Solution
Assign these files to a new group (let's call it voicemail) and
add asterisk and www-data to the group.
##### Step-By-Step
Generate the group:

    sudo addgroup voicemail
    
Add asterisk and www-data to the group (you might want to add yourself to the
group just in case):

    sudo adduser asterisk voicemail
    sudo adduser www-data voicemail

You need to sign out and in again really be part of the group and asterisk and
apache need to be restarted:

    sudo /etc/init.d/apache2 restart
    sudo /etc/init.d/asterisk restart

Now give the files and folders the appropriate permissions: User and group need
to be able to read, write and access the directorys list. Every newly created 
file should be of the folders group (voicemail).

    sudo chown -R asterisk:voicemail /var/spool/asterisk/voicemail/
    sudo find /var/spool/asterisk -type f -exec chmod 0660 {} \;
    sudo find /var/spool/asterisk -type d -exec chmod 2770 {} \;
    
One might need to set the umask of asterisk so newly created files have at least
the permission 660. TODO: check that 