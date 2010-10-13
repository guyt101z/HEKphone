<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('AsteriskSip', 'hekphone');

/**
 * BaseAsteriskSip
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $accountcode
 * @property string $callerid
 * @property string $canreinvite
 * @property string $context
 * @property string $host
 * @property integer $port
 * @property string $mailbox
 * @property string $md5secret
 * @property string $nat
 * @property string $permit
 * @property string $deny
 * @property string $mask
 * @property string $qualify
 * @property string $secret
 * @property string $type
 * @property string $username
 * @property string $defaultuser
 * @property string $useragent
 * @property string $fromuser
 * @property string $fromdomain
 * @property string $disallow
 * @property string $allow
 * @property string $ipaddr
 * @property string $mac
 * @property string $fullcontact
 * @property string $regexten
 * @property string $regserver
 * @property integer $regseconds
 * @property integer $lastms
 * 
 * @method integer     getId()          Returns the current record's "id" value
 * @method string      getName()        Returns the current record's "name" value
 * @method string      getAccountcode() Returns the current record's "accountcode" value
 * @method string      getCallerid()    Returns the current record's "callerid" value
 * @method string      getCanreinvite() Returns the current record's "canreinvite" value
 * @method string      getContext()     Returns the current record's "context" value
 * @method string      getHost()        Returns the current record's "host" value
 * @method integer     getPort()        Returns the current record's "port" value
 * @method string      getMailbox()     Returns the current record's "mailbox" value
 * @method string      getMd5secret()   Returns the current record's "md5secret" value
 * @method string      getNat()         Returns the current record's "nat" value
 * @method string      getPermit()      Returns the current record's "permit" value
 * @method string      getDeny()        Returns the current record's "deny" value
 * @method string      getMask()        Returns the current record's "mask" value
 * @method string      getQualify()     Returns the current record's "qualify" value
 * @method string      getSecret()      Returns the current record's "secret" value
 * @method string      getType()        Returns the current record's "type" value
 * @method string      getUsername()    Returns the current record's "username" value
 * @method string      getDefaultuser() Returns the current record's "defaultuser" value
 * @method string      getUseragent()   Returns the current record's "useragent" value
 * @method string      getFromuser()    Returns the current record's "fromuser" value
 * @method string      getFromdomain()  Returns the current record's "fromdomain" value
 * @method string      getDisallow()    Returns the current record's "disallow" value
 * @method string      getAllow()       Returns the current record's "allow" value
 * @method string      getIpaddr()      Returns the current record's "ipaddr" value
 * @method string      getMac()         Returns the current record's "mac" value
 * @method string      getFullcontact() Returns the current record's "fullcontact" value
 * @method string      getRegexten()    Returns the current record's "regexten" value
 * @method string      getRegserver()   Returns the current record's "regserver" value
 * @method integer     getRegseconds()  Returns the current record's "regseconds" value
 * @method integer     getLastms()      Returns the current record's "lastms" value
 * @method AsteriskSip setId()          Sets the current record's "id" value
 * @method AsteriskSip setName()        Sets the current record's "name" value
 * @method AsteriskSip setAccountcode() Sets the current record's "accountcode" value
 * @method AsteriskSip setCallerid()    Sets the current record's "callerid" value
 * @method AsteriskSip setCanreinvite() Sets the current record's "canreinvite" value
 * @method AsteriskSip setContext()     Sets the current record's "context" value
 * @method AsteriskSip setHost()        Sets the current record's "host" value
 * @method AsteriskSip setPort()        Sets the current record's "port" value
 * @method AsteriskSip setMailbox()     Sets the current record's "mailbox" value
 * @method AsteriskSip setMd5secret()   Sets the current record's "md5secret" value
 * @method AsteriskSip setNat()         Sets the current record's "nat" value
 * @method AsteriskSip setPermit()      Sets the current record's "permit" value
 * @method AsteriskSip setDeny()        Sets the current record's "deny" value
 * @method AsteriskSip setMask()        Sets the current record's "mask" value
 * @method AsteriskSip setQualify()     Sets the current record's "qualify" value
 * @method AsteriskSip setSecret()      Sets the current record's "secret" value
 * @method AsteriskSip setType()        Sets the current record's "type" value
 * @method AsteriskSip setUsername()    Sets the current record's "username" value
 * @method AsteriskSip setDefaultuser() Sets the current record's "defaultuser" value
 * @method AsteriskSip setUseragent()   Sets the current record's "useragent" value
 * @method AsteriskSip setFromuser()    Sets the current record's "fromuser" value
 * @method AsteriskSip setFromdomain()  Sets the current record's "fromdomain" value
 * @method AsteriskSip setDisallow()    Sets the current record's "disallow" value
 * @method AsteriskSip setAllow()       Sets the current record's "allow" value
 * @method AsteriskSip setIpaddr()      Sets the current record's "ipaddr" value
 * @method AsteriskSip setMac()         Sets the current record's "mac" value
 * @method AsteriskSip setFullcontact() Sets the current record's "fullcontact" value
 * @method AsteriskSip setRegexten()    Sets the current record's "regexten" value
 * @method AsteriskSip setRegserver()   Sets the current record's "regserver" value
 * @method AsteriskSip setRegseconds()  Sets the current record's "regseconds" value
 * @method AsteriskSip setLastms()      Sets the current record's "lastms" value
 * 
 * @package    hekphone
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseAsteriskSip extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('asterisk_sip');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'sequence' => 'asterisk_sip_id',
             'length' => 4,
             ));
        $this->hasColumn('name', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => true,
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('accountcode', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => false,
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('callerid', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => false,
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('canreinvite', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => false,
             'default' => 'yes',
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('context', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => true,
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('host', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => true,
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('port', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => false,
             'primary' => false,
             'length' => 4,
             ));
        $this->hasColumn('mailbox', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => false,
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('md5secret', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => false,
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('nat', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => true,
             'default' => 'no',
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('permit', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => false,
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('deny', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => false,
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('mask', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => false,
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('qualify', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => false,
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('secret', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => false,
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('type', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => true,
             'default' => 'friend',
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('username', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => true,
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('defaultuser', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => false,
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('useragent', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => false,
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('fromuser', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => false,
             'default' => 'NULL',
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('fromdomain', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => false,
             'default' => 'NULL',
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('disallow', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => false,
             'default' => 'all',
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('allow', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => false,
             'default' => 'ulaw;alaw',
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('ipaddr', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => false,
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('mac', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => false,
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('fullcontact', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => false,
             'default' => '',
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('regexten', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => false,
             'default' => '',
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('regserver', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => false,
             'default' => '',
             'primary' => false,
             'length' => '',
             ));
        $this->hasColumn('regseconds', 'integer', 8, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => false,
             'default' => '0',
             'primary' => false,
             'length' => 8,
             ));
        $this->hasColumn('lastms', 'integer', 8, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'notnull' => false,
             'default' => '0',
             'primary' => false,
             'length' => 8,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}