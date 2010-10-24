<?php

/**
 * Bills
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    hekphone
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Bills extends BaseBills
{
    public function getCalls()
    {
        return Doctrine_query::create()
               ->from('Calls c')
               ->addWhere('c.bill = ?', $this->id)
               ->execute();
    }
}
