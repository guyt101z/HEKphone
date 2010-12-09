<?php

class BillsCollection extends Doctrine_Collection
{

	/**
	 * This function generates the dtaus-Files and executes the program dtaus.
	 * @param string $start Date of the beginning of the billing period
	 * @param string $end Date of the end of the billing period
	 * @return boolean
	 */
	public function getDtaus($start, $end)
	{
		$date = date("d.m.Y",mktime(0, 0, 0, date("m"), date ("d"), date("Y")));

        //Head of the *.ctl File for the dtaus program The dtaus File (*.ctl) is needed for
        //the execution of the dtaus program which creates the files for the bank transactions
        $dtausHead = "BEGIN {
  Art   LK
  Name  HEK-PHONE
  Konto 105010993
  BLZ   52060410
  Datum $date
  Ausfuehrung   $date
  Euro
}

";

        $dtausContent = "";
	    foreach ($this as $bill)
        {
            $dtausContent .= $bill->getDtausEntry($start, $end);
        }

	//Creates the .ctl file for the dtaus programm and executes dtaus. Results are saved in /tmp/
        if (! $dtausContent == "")
        {
            $fileprefix = "/tmp/dtaus.$date";
            $ctl_handler = fopen($fileprefix.".ctl", "w+"); // Create file
            fWrite($ctl_handler, $dtausHead.$dtausContent);
            exec("cd /tmp/");
            exec("dtaus -dtaus -c $fileprefix.ctl -d $fileprefix.txt -o $fileprefix.sik -b $fileprefix.doc");
            exec ("chmod 770 $fileprefix.*");
            exec ("chgrp ".sfConfig::get("usergroup")." $fileprefix.*");

            return true;
        }
        else
        {
            return false;
        }
	}
}