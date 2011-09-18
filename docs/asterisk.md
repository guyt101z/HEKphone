### Voicemail Files Permissions

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