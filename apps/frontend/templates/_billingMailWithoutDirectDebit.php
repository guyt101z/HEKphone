Hallo <?php echo $firstName ?>,

hier ist die Rechnung fuer Deinen HEK-Telefonanschluss. 
Rechnungszeitraum: <?php echo $start ?> bis <?php echo $end ?> 
Rechnungsnummer  : <?php echo $billId?> 
Bitte bei Rueckfragen angeben.

************************
Gesamtbetrag: <?php echo round($amount,2) ?> Euro
************************  

Du hast diese Rechnung bereits bar bei einem HEKphone-Tutor bezahlt. 

Diese Rechnung wurde maschinell erstellt und ist ohne Unterschrift gueltig.

Einzelverbindungsnachweis:

<?php echo $itemizedBill?>