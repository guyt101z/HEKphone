<?php

/**
 * Calls
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    hekphone
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Calls extends BaseCalls
{
    /**
     * This function returns a formated string of this call for an itemized bill
     *
     * @return String
     */
    public function getItemizedBillEntry()
    {
        //Each value has a fix number of characters to get a nice format
        $itemizedBillEntry = str_pad($this['date'],21)
                            .str_pad($this['duration'],12)
                            .str_pad($this['destination'],25)
                            .str_pad($this['charges'],14)
                            .str_pad($this['Rates']['name'],18);
        
        return $itemizedBillEntry;
    }
}
