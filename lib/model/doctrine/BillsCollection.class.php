<?php

class BillsCollection extends Doctrine_Collection
{

	/**
	 * This function generates the dtaus-Files and executes the program dtaus.
	 * @param string $start Date of the beginning of the billing period
	 * @param string $end Date of the end of the billing period
	 * @return boolean
	 */
	public function createDtausFiles($start, $end)
	{
		$date = date("d.m.Y",mktime(0, 0, 0, date("m"), date ("d"), date("Y")));

        //Head of the *.ctl File for the dtaus program. The dtaus File (*.ctl) is needed for
        //the execution of the dtaus program which creates the files for the bank transactions
        $dtausHeader = "BEGIN {
  Art	LK
  Name	" . sfConfig::get('hekphoneName') . "
  Konto	" . sfConfig::get('hekphoneAccountnumber') . "
  BLZ	" . sfConfig::get('hekphoneBanknumber') . "
  Datum	$date
  Ausfuehrung	$date
  Euro
}

";
        
        $dtausContent = "";
        
        //get the required data for the dtaus content and footer
        foreach ($this as $bill)        
        {
        	if  ($bill['amount'] > 0) 
        	{
                try
                {
                	$dtausContent .= $bill->getDtausEntry($start, $end);
	                $sumAmount += $bill['amount'];
	                $sumAccounts += $bill['Residents']['account_number'];
	                $sumBankNumbers += $bill['Residents']['bank_number'];
                }
                catch (Exception $e)
                {
                    //$this->log($this->formatter->format($e->getMessage(), 'ERROR'));
                    echo $e->getMessage();
                
        	    }
        	}
        }
      //Footer of the *.ctl file for the dtaus program.
      $dtausFooter = "END {
  Anzahl	".count($this)."
  Summe	" . $sumAmount."
  Kontos	" . $sumAccounts."
  BLZs	" . $sumBankNumbers."
}";

     echo "Amount of all bills: " . $sumAmount . "Euro" . PHP_EOL;
     

	//Creates the .ctl file for the dtaus programm and executes dtaus. Results are saved in /tmp/
        if (! $dtausContent == "")
        {
            $fileprefix = sfConfig::get("sf_data_dir") . DIRECTORY_SEPARATOR . "billing" . DIRECTORY_SEPARATOR . "dtaus.$date";
            $ctl_handler = fopen($fileprefix.".ctl", "w+"); // Create file
            fWrite($ctl_handler, $dtausHeader.$dtausContent.$dtausFooter);
            exec("cd " . sfConfig::get("sf_data_dir") . DIRECTORY_SEPARATOR . "billing" . DIRECTORY_SEPARATOR );
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

	public function sendEmails($start, $end)
	{
	    foreach($this as $bill)
	    {
	        $bill->sendEmail($start, $end);
	    }
	}
}
