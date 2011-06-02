<?php

class BillsCollection extends Doctrine_Collection
{
    protected $dtausBody;
    protected $banknumberSum;
    protected $accountnumberSum;
    protected $totalAmount;

    /**
     * Calculate the totalAmount and the checksums (account number sum and bank
     * number sum) on construction.
     */
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

    /**
     * Returns the header for the dtaus .ctl file which are sent to the bank
     * to do the debit.
     *
     * @return string
     */
    protected function getDtausHeader() {
        $date = date("d.m.Y");

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

    /**
     * Returns the body for the dtaus .ctl file which are sent to the bank
     * to do the debit.
     * The body consists of one entry per bill which is created using the
     * getDtausEntry() method of the bill.
     *
     * @return string
     */
    protected function getDtausBody() {
        $dtausBody = "";
        foreach($this->bills as $bill) {
          // getDtausEntry returns false when the amount is zero
          // appending false to a string appends nothing.
          $dtausBody .= $bill->getDtausEntry();
        }

        return $dtausBody;
    }

    /**
     * Returns the footer for the dtaus .ctl file which are sent to the bank
     * to do the debit.
     * The footer contains the sum of all account numbers, bank numbers and
     * the total amount of the debits as checksum.
     *
     * @return string
     */
    protected function getDtausFooter() {
        $dtausFooter = "END {
  Anzahl    " . count($this) . "
  Summe "     . $this->getTotalAmount() . "
  Kontos    " . $this->getAccountnumberSum() . "
  BLZs  "     . $this->getBanknumbersSum() . "
}";

        return $dtausFooter();
    }

    /**
     * Returns the total amount of all bills in the collection.
     *
     * @return string
     */
    public function getTotalAmount() {
        return $this->totalAmount;
    }

    /**
     * Returns the sum of all bank account numbers where a debit is created.
     * This serves as checksum for the dtaus program.
     *
     * @return string
     */
    protected function getAccountnumberSum() {
        return $this->accountnumberSum;
    }

    /**
     * Returns the sum of all bank numbers where a debit is created.
     * This serves as checksum for the dtaus program.
     *
     * @return string
     */
    protected function getBanknumberSum() {
        return $this->banknumberSum;
    }

    /**
     * Return the complete contents of the dtaus .ctl file that are used with the
     * banks programm to do the debit.
     * @return string
     */
    public function getDtausContents() {
        return $this->getDtausHeader()
              . $this->getDtausBody()
              . $this->getDtausFooter();
    }

    /**
     * Write the .ctl file to the data/billing folder and execute dtaus on this
     * file. There will be 4 files created: dtaus.{$date}.ctl/.txt/.sik/.doc
     * the owner of the files will be set to the according config variable.
     *
     * @return string|string
     */
    public function writeDtausFiles() {
        if($this->getDtausBody) {
            $date = date("d.m.Y");

            $fileprefix = sfConfig::get("sf_data_dir") . DIRECTORY_SEPARATOR . "billing" . DIRECTORY_SEPARATOR . "dtaus.$date";
            $ctl_handler = fopen($fileprefix.".ctl", "w+"); // Create file
            fWrite($ctl_handler, $this->getDtausContents());
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

    /**
     * For every bill of the collection: Changes the field "bill" of every
     * unbilled call in the given time-period to the according bill id.
     * First the bills in the collection need ids, so call save() first.
     *
     * @throws Exception if a bill has already some calls linked
     * @throws Exception if the bill amount differs from the amount of calls to be linked
     * @TODO: catch the errors so the proccess won't stop when it's halfway
     *        done or provide an easy way to pick up te process again.
     */
    public function linkCallsToBills(){
        foreach($this as $bill) {
            $bill->linkCalls();
        };

        return $this;
    }

	/**
	 * Send emails for every bill notifiying the resident about his bill.
	 * @TODO: catch the errors so the proccess won't stop when it's halfway
	 *        done or provide an easy way to pick up te process again.
	 */
	public function sendEmails()
	{
	    foreach($this as $bill)
	    {
	        $bill->sendEmail();
	    }

	    return $this;
	}
}
