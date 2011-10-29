# Installing & Configuring Postgresql
## Install packages
On your server do

    sudo aptitude install postgresql-client-9.1 php5-pgsql

this will install the PDO driver for postgres and the postgres database.

## Set postgres up to use password authentication
By default, access to the database is tied to unix users. We want to
use native postgresql users and passwords.

To achive this add in */etc/postgresql/9.1/main/pg_hba.conf* after:

    # Database administrative login by Unix domain socket
    local   all             postgres                                peer

the following 

    # TYPE  DATABASE        USER            ADDRESS                 METHOD
    local   all             all             		            password

Finally, restart postgresql:

    sudo /etc/init.d/postgresql restart

## Create users
Now we need to create a postgres user and the database. The first command
will create the user hekphone and prompt for a password, the second will
create a database named hekphone with the owner hekphone.

    sudo -u postgres createuser -d -R -S -P hekphone
    sudo -u postgres createdb -O hekphone hekphone

We also want to let asterisk access the database but with limited rights, so we
create an additional user:

    sudo -u postgres createuser -D -R -S -P asterisk

## Check whether everything works as expected
You should now be able to connect to your database using the postgresql
command line tool:

    psql hekphone hekphone

Tthe command will promt you for a passwort. After you logged in, you can quit
vy typing \q [ENTER]. \? and \h will get you started using the command line
tool, but you should never have to enter the psql console again.