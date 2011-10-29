# Deploy

## Setting up your system
The following guides rely on a Debian/Ubuntu system.

See *docs/asterisk.md* how to set up asterisk to use realtime peers from asterisk_sip,
realtime extensions from asterisk_extensions and csv-cdr storage from
asterisk_cdr and to connect to the telecom PSTN. You can also learn there how
to configure voicemailboxes for your users (and you should do this or disable
the module in the frontend). As these parts concern the German PSTN "Deutsche
Telekom" and documentation has already begun in German the document is German.
Sorry. 

See *docs/dhcpd.md* how to set up your dhcp-server properly so the scripts can 
add phones that need an IP.

See *docs/apache.md* how to set up your apache webserver for the symfony frontend.

See *docs/php.md* how to configure your php installation. You need at least php5.3.

See *docs/postgresql.md* to learn quickly how to install and configure your a
postgresql database to use password authentication.

## Setting up the frontend and cli scripts.

You also have to define some basic information about you as provider. This is 
done by editing *config/ProjectConfiguration.class.php*. 

### Install dependencies
The application relies on a few plugins to symfony and third party libarys.
you will have to fetch the dependencies by executing
  
    git submodule init
    git submodule update

while being in the symfony project root folder.

To install Payment DTA (used to create invoice messages) use pear

    sudo aptitude install php-pear
    sudo pear install Payment_DTA

(You'll find more information on: http://pear.php.net/package/Payment_DTA )


### Setting up the database

Once you've cloned the code to your machine, you have to create the neccesary
database structure. Edit *config/databases.yml* appropriately to establish the 
connection to the database. Then executing the doctrine:build task:

    php symfony doctrine:build --all

See *config/doctrine/schema.yml* for detailed information on all relations.
Asterisk (see asterisk.md again) does not access the Phones relation directly
but via a view (asterisk_sip). This is done to avoid duplicated information 
in the database which could lead to inconsistencies. Create the view by piping 
*config/postgres0***.sql* to your database. You can do this with the following
commands:

    psql databasename username -f postgres01-typecast-bool-context.sql
    psql databasename username -f postgres02-asterisk_sip-view.sql

You can find more information on this relation in the schema file mentioned 
above.

### Getting data into the database
If you just want to try out the system, you can load the fixtures by executing:

    php symfony doctrine:data-load
    
To reset the database afterwards you just call the doctrine:build task again.
    
You should load the data used to validate the residents account information now 
by running the hekphone:update-banks task. (Otherwise you won't be able to
unlock any user.) The following command fetches the current information on 
bank numbers from the Bundesbank website and inserts it in the database:

    php symfony hekphone:update-banks

You can refetch the data at any time with the mentioned task or the equivalent 
link in the webfrontend (tasks->update bank information).

If you have set up your *config/databases.yml* correctly and on the remote side
everything's okay, you can now call the task hekphone:sync-residents-data
    
    php symfony hekphone:sync-residents-data
    
to fetch your residents data from a remote database. You might want to set up
some cronjobs right away. See *docs/cronjobs.md* for sample a configuration.
 