<?php

class BillsCollection extends Doctrine_Collection
{
    protected $dtausBody;
    protected $banknumberSum;
    protected $accountnumberSum;
    protected $totalAmount;

    public function _construct() {
        foreach ($this as $bill)
        {
            if  ($bill['amount'] > 0)
            {
                $this->totalAmount += $bill['amount'];
                $this->accountnumberSum += $bill['Residents']['account_number'];
                $this->banknumberSum += $bill['Residents']['bank_number'];
            }
        }
    }

    protected function getDtausHeader() {
        $date = date("d.m.Y",mktime(0, 0, 0, date("m"), date ("d"), date("Y")));

        $dtausHeader = "BEGIN {
  Art   LK
  Name  " . sfConfig::get('hekphoneName') . "
  Konto " . sfConfig::get('hekphoneAccountnumber') . "
  BLZ   " . sfConfig::get('hekphoneBanknumber') . "
  Datum $date
  Ausfuehrung   $date
  Euro
}

";
        return $dtausHeader;
    }

    protected function getDtausBody() {
        $dtausBody = "";
        foreach($this->bills as $bill) {
          // getDtausEntry returns false when the amount is zero
          // appending false to a string appends nothing.
          $dtausBody .= $bill->getDtausEntry();
        }

        return $dtausBody;
    }

    protected function getDtausFooter() {
        $dtausFooter = "END {
  Anzahl    " . count($this) . "
  Summe "     . $this->getTotalAmount() . "
  Kontos    " . $this->getAccountnumberSum() . "
  BLZs  "     . $this->getBanknumbersSum() . "
}";

        return $dtausFooter();
    }

    protected function getTotalAmount() {
        return $this->totalAmount;
    }

    protected function getAccountnumberSum() {
        return $this->accountnumberSum;
    }

    protected function getBanknumberSum() {
        return $this->banknumberSum;
    }

    public function writeDtausFiles() {
                  print_r($this->bills->toArray());
        if($this->getDtausBody) {
            $date = date("d.m.Y",mktime(0, 0, 0, date("m"), date ("d"), date("Y")));

            $fileprefix = sfConfig::get("sf_data_dir") . DIRECTORY_SEPARATOR . "billing" . DIRECTORY_SEPARATOR . "dtaus.$date";
            $ctl_handler = fopen($fileprefix.".ctl", "w+"); // Create file
            fWrite($ctl_handler, $this->getDtausHeader()
                                . $this->getDtausBody()
                                . $this->getDtausFooter());
            exec("cd " . sfConfig::get("sf_data_dir") . DIRECTORY_SEPARATOR . "billing" . DIRECTORY_SEPARATOR );
            exec("dtaus -dtaus -c $fileprefix.ctl -d $fileprefix.txt -o $fileprefix.sik -b $fileprefix.doc");
            exec ("chmod 770 $fileprefix.*");
            exec ("chgrp ".sfConfig::get("usergroup")." $fileprefix.*");

            return true;
        }
        else
        {
            return false;
        };
    }

	public function sendEmails()
	{
	    foreach($this as $bill)
	    {
	        $bill->sendEmail();
	    }
	}
}
