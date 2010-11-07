<?php

/**
 * AsteriskExtensionsTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class AsteriskExtensionsTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object AsteriskExtensionsTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('AsteriskExtensions');
    }

    /**
     * The function updates/creates the extension neccesary to dial to the sip
     * phone of a user
     *
     * The extensions are generated in the context 'phones' which can be
     * included in the context 'locked' and 'unlocked' and 'amt' (which is
     * what you reach if you call from outside)
     *
     * @param integer $extension
     * @param integer $residentid
     * @return string
     */
    public function updateResidentsExtension($extension, $residentid = false)
    {
        $extensionPrefix = '_8695';
        $context  = 'phones';
        $resident = Doctrine_Core::getTable('Residents')->findOneById($residentid);

        // Merciless delete any old entries of the room/phone: //
        $this->createQuery()
           ->where('exten = ?', $extensionPrefix . $extension)
           ->addWhere('context = ', $context)
           ->delete();

        // Prepare the extensions entries: //
        // call the phone located in the room
        $arrayExtensions[] = array(
             'exten'        => $extensionPrefix . $extension,
             'priority'     => 1,
             'context'      => $context,
             'app'          => 'Dial',
             'appdata'      => 'SIP/' . $extension
        );

        // include forwarding to mailbox if it's active
        // this is resident specific so only insert it if
        // there's a residentid provided
        $vm_active = true;
        if ($vm_active && $residentid)
        {
            $arrayExtensions[] = array(
                'exten'        => $extensionPrefix . $extension,
                'priority'     => 2,
                'context'      => $context,
                'app'          => 'Voicemail',
                'appdata'      => $resident->id . '@default'
            );
        }

        // hangup after the call finished
        $arrayExtensions[] = array(
            'exten'        => $extensionPrefix . $extension,
            'priority'     => 99,
            'context'      => $context,
            'app'          => 'Hangup',
            'appdata'      => ''
        );

        // Insert the new extension in the database: //
        $collExtensions = Doctrine_Collection::create('AsteriskExtensions');
        $collExtensions->fromArray($arrayExtensions);
        $collExtensions->save();

        return true;
    }
}