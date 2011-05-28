<?php

/**
 * The class represents a Voicemessage on filesystem level.
 *
 * @author hannes
 *
 */
class Voicemessage {
    protected $id;
    protected $timestamp;
    protected $duration;
    protected $callerid;
    protected $new;
    protected $voicemailbox;

    public function __construct($voicemailbox, $id, $new) {
        $this->voicemailbox  = $voicemailbox;
        $this->id            = $id;
        $this->new           = $new;

        /* get the message details from the corresponding info file */
        $messageInformation = parse_ini_file($this->getInfoFilename());
        $this->duration  = $messageInformation['duration'];
        $this->timestamp = $messageInformation['origtime'];
        $this->callerid  = $messageInformation['callerid'];
    }

    protected function getSubfolder() {
        if($this->new) {
            return VoicemessageFolder::NEW_MESSAGES_FOLDER;
        } else {
            return VoicemessageFolder::OLD_MESSAGES_FOLDER;
        }
    }

    protected function getVoicemailboxRootPath() {
        return $voicemailboxRootPath = sfConfig::get('asteriskVoicemailDir')
            . DIRECTORY_SEPARATOR . $this->voicemailbox
            . DIRECTORY_SEPARATOR;
    }
    protected function getInfoFilename() {
        return $this->getVoicemailboxRootPath() . $this->getSubfolder() . DIRECTORY_SEPARATOR
                . 'msg' . str_pad($this->id, 4, '0', STR_PAD_LEFT) . '.txt';
    }

    public function getSoundFilename() {
        return $this->getVoicemailboxRootPath() . $this->getSubfolder() . DIRECTORY_SEPARATOR
                . 'msg' . str_pad($this->id, 4, '0', STR_PAD_LEFT) . '.wav';
    }

    public function delete()
    {
      $filenameWithoutExtension = $this->getVoicemailboxRootPath() . $this->getSubfolder() . DIRECTORY_SEPARATOR
                . 'msg' . str_pad($this->id, 4, '0', STR_PAD_LEFT);

      if( ! unlink($filenameWithoutExtension . '.txt') ||
          ! unlink($filenameWithoutExtension . '.wav') ||
          ! unlink($filenameWithoutExtension . '.WAV') ||
          ! unlink($filenameWithoutExtension . '.gsm')
        ) {
          return false;
        } else {
          return true;
        }
    }
    public function markAsOld() {
        // move the associated files
        $toId = VoicemessageFolder::getVoicemailbox($this->voicemailbox)->getHighestOldMessageId();
        $from = $this->getVoicemailboxRootPath() . $this->getSubfolder() . DIRECTORY_SEPARATOR
                . 'msg' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
        $to   = $this->getVoicemailboxRootPath() . VoicemessageFolder::OLD_MESSAGES_FOLDER . DIRECTORY_SEPARATOR
                . 'msg' . str_pad($toId, 4, '0', STR_PAD_LEFT);

        if( ! rename($from . '.wav', $to . '.wav') ||
            ! rename($from . '.WAV', $to . '.WAV') ||
            ! rename($from . '.txt', $to . '.txt') ||
            ! rename($from . '.gsm', $to . '.gsm')
          ) {
            VoicemessageFolder::getVoicemailbox($this->voicemailbox)->loadMessages();
            return false;
        } else {
            VoicemessageFolder::getVoicemailbox($this->voicemailbox)->loadMessages();
            return true;
        }
    }

    public function markAsNew() {
        // move the associated files
        $toId = VoicemessageFolder::getVoicemailbox($this->voicemailbox)->getHighestNewMessageId();
        $from = $this->getVoicemailboxRootPath() . $this->getSubfolder() . DIRECTORY_SEPARATOR
                . 'msg' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
        $to   = $this->getVoicemailboxRootPath() . VoicemessageFolder::NEW_MESSAGES_FOLDER . DIRECTORY_SEPARATOR
                . 'msg' . str_pad($toId, 4, '0', STR_PAD_LEFT);

        if( ! rename($from . '.wav', $to . '.wav') ||
            ! rename($from . '.WAV', $to . '.WAV') ||
            ! rename($from . '.txt', $to . '.txt') ||
            ! rename($from . '.gsm', $to . '.gsm')
          ) {
            VoicemessageFolder::getVoicemailbox($this->voicemailbox)->loadMessages();
            return false;
        } else {
            VoicemessageFolder::getVoicemailbox($this->voicemailbox)->loadMessages();
            return true;
        }
    }

    public function getCallerid() {
        return $this->callerid;
    }

    public function getDuration() {
        return $this->duration;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function getDatetime($format = 'Y-m-d h:m') {
        return date($format, $this->timestamp);
    }

    public function getId() {
        return $this->id;
    }

    public function isNew() {
        return $this->new;
    }

    public function getVoicemailboxId() {
        return $this->voicemailbox;
    }

    public function getMessage() {
      $filehandle = fopen($this->getSoundFilename());

      return fread($filehandle, filesize($this->getSoundFilename()));
    }

    public function toArray() {
        return array('id'           => $this->id,
                     'timestamp'    => $this->timestamp,
                     'datetime'     => $this->getDatetime(),
                     'duration'     => $this->duration,
                     'callerid'     => $this->callerid,
                     'new'          => $this->new,
                     'voicemailbox' => $this->voicemailbox);
    }

}
