Folgende Bewohner sind heute ausgezogen und wurden gesperrt:
<?php
// table header
echo str_pad('Zimmernr.',10)
     . str_pad('Vorname, Nachname',25)
     . str_pad('offene Rechnung', 15) . PHP_EOL
     . str_pad('',50, '-') . PHP_EOL;

//table body
foreach($residentsMovingOut as $resident) {
    echo str_pad($resident->Rooms,10)
         . str_pad($resident->first_name . " " . $resident->last_name ,25)
         . str_pad($resident->getCurrentBillAmount() . 'EUR', 15) . PHP_EOL;
}

?>

Die Rechnung wird beim nächsten Rechnungserstellen ganz normal vom angegebenen Konto abgebucht.

---
Das war der Task: 'hekphone:check-residents-moving-out' mit den Optionen --notify-team und --silent. Via cronjob von hekphone@hekphone.
