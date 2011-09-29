<?php

class hekphoneSyncresidentsdataTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('sourceDb', null, sfCommandOption::PARAMETER_REQUIRED, 'The source connection name', 'hekdb'),
      new sfCommandOption('destinationDb', null, sfCommandOption::PARAMETER_REQUIRED, 'The destination connection name', 'hekphone'),
      new sfCommandOption('source', null, sfCommandOption::PARAMETER_REQUIRED, 'The source db name', 'HekdbCurrentResidents'),
      new sfCommandOption('destination', null, sfCommandOption::PARAMETER_REQUIRED, 'The destination db name', 'Residents'),

      new sfCommandOption('silent', null, sfCommandOption::PARAMETER_NONE, 'Suppress logging to stdout. '),
    ));

    $this->namespace        = 'hekphone';
    $this->name             = 'sync-residents-data';
    $this->briefDescription = 'Syncs the residents data between two database tables';
    $this->detailedDescription = <<<EOF
The [hekphone:sync-residents-data|INFO] task helps adding new users to the database of the project from a remote database.

Call it with:

  [php symfony hekphone:sync-residents-data|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $logger = new sfAggregateLogger($this->dispatcher);
    $logger->addLogger(new sfFileLogger($this->dispatcher, array('file' => $this->configuration->getRootDir() . '/log/cron-sync_residents_data.log')));
    if( ! $options['silent']) {
        $logger->addLogger(new sfCommandLogger($this->dispatcher));
    }

    $sourceResidentsTable = Doctrine_Core::getTable($options['source']);
    $destinationResidentsTable = Doctrine_Core::getTable($options['destination']);
    $roomTable = Doctrine_Core::getTable('Rooms');

    // Sets the key of the collection array to the ID of the record
    $sourceResidentsTable->setAttribute(Doctrine_Core::ATTR_COLL_KEY, 'id');
    $destinationResidentsTable->setAttribute(Doctrine_Core::ATTR_COLL_KEY, 'id');
    $roomTable->setAttribute(Doctrine_Core::ATTR_COLL_KEY, 'id');


    /* Fetch all source and destination residents */
    // FIXME: This is non-performant.
    $sourceResidents = $sourceResidentsTable->findAll();
    $destinationResidents = $destinationResidentsTable->findAll();

    $numNew = 0;
    $numOld = 0;
    $failedPartly = false;
    foreach ($sourceResidents as $sourceResident) {
        //Keep track of what we do (statitics):
        if ( ! isset($destinationResidents[$sourceResident->id])) {
            $logger->info("Syncing new user with id={$sourceResident->id} name='{$sourceResident->first_name} {$sourceResident->last_name}'.");
            $numNew++;
        } else {
            if ($destinationResidents[$sourceResident->id]->first_name != $sourceResident->first_name
                && $destinationResidents[$sourceResident->id]->last_name != $sourceResident->last_name) {
                    // Normaly, the name of a user should not change. Something might be wrong.
                    $logger->warning("Name of user with id={$sourceResident->id} changed from '{$destinationResidents[$sourceResident->id]->first_name} {$destinationResidents[$sourceResident->id]->last_name}' "
                    . "to '{$sourceResident->first_name} {$sourceResident->last_name}'");
            }
            $numOld++;
        }

        // Transfer the base date for the record from hekDb to hekphoneDb.
        // If it does not yet exist it will be generated automatically:
        $destinationResident = $destinationResidents[$sourceResident->id]; // = does not clone the object but merely references to it.
        $destinationResident->id         = $sourceResident->id;
        $destinationResident->first_name = $sourceResident->first_name;
        $destinationResident->last_name  = $sourceResident->last_name;
        $destinationResident->move_in    = $sourceResident->move_in;
        $destinationResident->move_out   = $sourceResident->move_out;
        if( ! $sourceResident->room_no) {
            $destinationResident->room   = $destinationResident->room;  // Room No stays the same even on move_out
        } else {
            $roomId = $roomTable->findOneByRoom_no($sourceResident->room_no)->id;
            if ( ! $roomId ) {
                $logger->err("Syncing user id={$sourceResident->id}, name='{$sourceResident->first_name} {$sourceResident->last_name}' failed: Room not found!.");
                $failedPartly = true;
                $roomId = NULL;
            }
            $destinationResident->room = $roomId;
        }
    }

    $destinationResidents->save();
    $logger->info("Synced $numOld old user entries and $numNew new entries.");

    if ( $failedPartly )
        exit(1);
    else
        exit(0);
  }
}
