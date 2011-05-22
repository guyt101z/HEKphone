<?php

/**
 * Represents a Voicemailbox on filesystem level. Holds all associated Voicemessages.
 * This is a singleton class. Use VoicemessageFolder::getVoicemailbox($vmboxId)
 *
 * @author hannes
 *
 */
class VoicemessageFolder {
    protected $newMessages = array();
    protected $oldMessages = array();
    protected $voicemailboxId;
    protected $voicemailboxRootDir;

    const OLD_MESSAGES_FOLDER = 'Old';
    const NEW_MESSAGES_FOLDER = 'INBOX';


    /* Singleton class */
    private static $instance;

    /**
     * To prevent the class being instanciated via new VoicemessageFolder() the
     * constructor is private
     */
    private function __construct() {
      //nothing to see here. go away
    }

    /**
     * Don't allow cloning as it's a singleton.
     */
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    /**
     * Get an instance of the object via VoicemessageFolder::getVoicemailbox($id)
     * rather than using new... (singleton)
     * @param unknown_type $voicemailboxId
     */
    public static function getVoicemailbox($voicemailboxId) {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }

        self::$instance->voicemailboxRootDir = sfConfig::get('asteriskVoicemailDir') . DIRECTORY_SEPARATOR . $voicemailboxId;
        self::$instance->voicemailboxId = $voicemailboxId;

        if( ! file_exists(self::$instance->voicemailboxRootDir)) {
            return false;
        }

        self::$instance->loadMessages();

       return self::$instance;
    }


    /**
     * Gets a filelist of the files in the "INBOX" folder of the mailbox
     *
     * @return array list of files
     */
    private function scanForNewMessages() {
        $filelist = scandir($this->voicemailboxRootDir . DIRECTORY_SEPARATOR . VoicemessageFolder::NEW_MESSAGES_FOLDER);
        $messages = array();
        foreach($filelist as $filename) {
            if(strpos($filename, 'msg') === false) {
                continue;
            }

            $messages[(int)substr($filename, 3,4)] = $filename;
        }

        return $messages;
    }

    /**
     * Gets a filelist of the files in the "Old" folder of the mailbox
     *
     * @return array list of files
     */
    private function scanForOldMessages() {
        $filelist = scandir($this->voicemailboxRootDir . DIRECTORY_SEPARATOR . VoicemessageFolder::OLD_MESSAGES_FOLDER);
        $messages = array();
        foreach($filelist as $filename) {
            if(strpos($filename, 'msg') === false) {
                continue;
            }

            $messages[(int)substr($filename, 3,4)] = $filename;
        }

        return $messages;
    }

    /**
     * Gets all messages that are present in the "Old" folder as instance of
     * Voicemessage.
     *
     * @return array(Voicemessage)
     */
    private function loadOldMessages() {
        $this->oldMessages = array();

        $oldMessageList = $this->scanForOldMessages();
        foreach($oldMessageList as $id => $soundFilename) {
            $this->oldMessages[$id] = new Voicemessage($this->voicemailboxId, $id, false);
        }

        return $this->oldMessages;
    }

    /**
     * Gets all messages that are present in the "INBOX" folder as instance of
     * Voicemessage.
     *
     * @return array(Voicemessage)
     */
    private function loadNewMessages() {
        $this->newMessages = array();

        $newMessageList = $this->scanForNewMessages();
        foreach($newMessageList as $id => $soundFilename) {
            $this->newMessages[$id] = new Voicemessage($this->voicemailboxId, $id, true);
        }

        return $this->newMessages;
    }

    /**
     * Loads all messages of the associated mailbox
     */
    public function loadMessages() {
        $this->loadOldMessages();
        $this->loadNewMessages();
    }

    /**
     * Get all new messages of the mailbox
     * @return array(Voicemessages)
     */
    public function getNewMessages() {

        return $this->newMessages;
    }

    /**
     * Get all new messages of the mailbox
     * @return array(Voicemessages)
     */
    public function getOldMessages() {

        return $this->oldMessages;
    }

    /**
     * Get a message from the "Old" folder with id $id;
     *
     * @param integer $id
     * @return Voicemessage or false if no such message exists
     */
    public function getOldMessage($id) {
        if(array_key_exists($id, $this->oldMessages)) {
            return $this->oldMessages[$id];
        } else {
            return false;
        }
    }

    /**
     * Get a message from the "INBOX" folder with id $id;
     *
     * @param integer $id
     * @return Voicemessage or false if no such message exists
     */
    public function getNewMessage($id) {
        if(array_key_exists($id, $this->newMessages)) {
            return $this->newMessages[$id];
        } else {
            return false;
        }
    }

    /**
     * Get all associated messages (new and old ones) as associative array
     *
     * @return array
     */
    public function toArray() {
        $messages = array();
        foreach($this->oldMessages as $id => $oldMessage) {
            $messages['old'][$id] = $oldMessage->toArray();
        }

        foreach($this->newMessages as $id => $newMessage) {
            $messages['new'][$id] = $newMessage->toArray();
        }

        return $messages;
    }

    public function getHighestOldMessageId() {
        if(count($this->oldMessages) == 0){
          return 0;
        }
        return end($this->oldMessages)->getId()+1;
    }

    public function getHighestNewMessageId() {
        if(count($this->newMessages) == 0){
          return 0;
        }
        return end($this->newMessages)->getId()+1;
    }
}