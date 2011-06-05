<?php
require_once('Payment/DTA.php');

class BillsCollection extends Doctrine_Collection
{
    protected $dtaus;  // holds the DTA-object representing the dtaus file
    protected $totalAmount;

    /**
     *
     * @return string
     */
    public function getDtaus() {
        $this->dtaus = new DTA(DTA_DEBIT);
        $this->dtaus->setAccountFileSender(
            array(
                "name"           => sfConfig::get('hekphoneName'),
                "bank_code"      => sfConfig::get('hekphoneBanknumber'),
                "account_number" => sfConfig::get('hekphoneAccountnumber')
            )
        );
        foreach($this as $bill) {
            if($bill['amount'] > 0) {
                if( ! $bill['Residents']['first_name'] || ! $bill['Residents']['last_name'] || ! $bill['Residents']['account_number'] || ! $bill['Residents']['bank_number']) {
                    throw new Exception("Missing Details for the dtaus creation proccess for bill id=" . $bill['id']);
                }

                $addResult = $this->dtaus->addExchange(
                    $residentsDetails = array(
                        "name"           => $bill['Residents']['first_name'] . " " . $bill['Residents']['first_name'],
                        "bank_code"      => $bill['Residents']['bank_number'],
                        "account_number" => $bill['Residents']['account_number']
                    ),
                    $bill['amount'],
                    array(                                      // Description of the transaction ("Verwendungszweck").
                        sfConfig::get("transactionName") . " " . $bill['id'],
                        $bill['billingperiod_start'] . " BIS " . $bill['billingperiod_end']
                    )
                );

                if( ! $addResult) {
                    return $addResult;
                }
            }
        }

        return $this->dtaus;
    }

    public function getDtausContents() {
        if( ! $dtaus = $this->getDtaus()) {
            return $dtaus;
        }

        return $this->getDtaus()->getFileContent();
    }

    /**
     * Returns the total amount of all bills in the collection.
     *
     * @return string
     */
    public function getTotalAmount() {
        if($this->totalAmount == NULL) {
          foreach($this as $bill) {
            $this->totalAmount += $bill['amount'];
          }
        }

        return $this->totalAmount;
    }

    /**
     * Returns an array of errors that would stop the bill creation or sending
     * process.
     *
     * Checks for: Empty Account Information,
     *             Empty Name
     *             Empty Email
     *             Bill amount that do not match the sum of calls charges in the bill period
     *             Bill has already related calls
     *
     */
    public function hasErrors() {
        $errors = false;
        foreach($this as $bill) {
          //FIXME: i18n???
            if($bill['Residents']['last_name']  == null && $bill['amount'] != 0) {
                $errors[] = "Resident=" . $bill['resident'] . " has no last name set.";
            }

            if($bill['Residents']['account_number'] == null || $bill['Residents']['bank_number'] == null && $bill['amount'] != 0) {
                $errors[] = "Resident=" . $bill['resident'] . " has no account information.";
            }

            //FIXME: only use one query not about 200
            $newAmount = Doctrine_Query::create()
                ->from('Calls c')
                ->select('sum(charges)/100')
                ->where('resident = ?', $bill->resident)
                ->addWhere('bill is null')
                ->addWhere('date <= ?', $bill->get('billingperiod_end') . ' 23:59:59')
                ->addWhere('date >= ?', $bill->get('billingperiod_start'))
                ->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)
                ->execute();

            if($newAmount != $bill->amount) {
                $errors[] = "The amount of the of resident =" . $bill['resident'] . " changed between creation of the bill and allocating the calls to the bill.";
            }
        }

        return $errors;
    }

    /**
     * Returns an array of errors that would stop the process of creating dtaus files.
     *
     * Checks for: Empty Account Information,
     *             Empty Name
     */
    public function hasDtausErrors() {
        $errors = false;

        if(count($this) == 0) {
            $errors[] = "Keine Rechnungen, keine Dtaus-Datei.";
        }
        foreach($this as $bill) {
            //FIXME: i18n???
            if($bill['amount'] == 0) {
              continue; // bills with amount of zero won't apperar in the dtaus files
            }
            if($bill['Residents']['last_name']  == null) {
                $errors[] = "Resident=" . $bill['resident'] . " has no last name set.";
            }

            if($bill['Residents']['account_number'] == null || $bill['Residents']['bank_number'] == null) {
                $errors[] = "Resident=" . $bill['resident'] . " has no account information.";
            }
        }

        return $errors;
    }

    /**
     * There will be 1 file created: dtaus.{$date}.dtaus
     * the owner of the files will be set to the according config variable.
     *
     * @return bool
     */
    public function writeDtausFile() {
        $filename = sfConfig::get("sf_data_dir") . DIRECTORY_SEPARATOR . "billing" . DIRECTORY_SEPARATOR . date("d.m.Y") . "txt";
        if($this->getDtaus()->saveFile($filename)) {
            exec ("chmod 770 " . $filename);
            exec ("chgrp " . sfConfig::get("usergroup") . " " . $filename);

            return true;
        } else {
            return false;
        };
    }

    /* Checks if any of the collections bills exists in the database */
    public function exists() {
        foreach($this as $bill) {
            if($bill->exists()) {
                return true;
            }
        }

        return false;
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

	public function markAsDebited() {
	    $billids = array();
	    foreach($this as $bill) {
	        $billids[] = $bill->get('id');
	    }

	    Doctrine_Query::create()
	      ->update('Bills b')
	      ->set('b.debit_sent', 'true')
	      ->whereIn('b.id', $billids)
	      ->execute();


	    return $this;
	}
}
