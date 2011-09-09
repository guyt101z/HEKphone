Folgende Bewohner sind gestern ausgezogen:
<?php
// table header
echo str_pad('Zimmer', 8)
     . str_pad('Vorname, Nachname', 26)
     . str_pad('offene Rechnung', 16)
     . str_pad('Sperrung', 30) . PHP_EOL
     . str_pad('', 80, '-') . PHP_EOL;

//table body
foreach($residentsMovingOut as $resident) {
    echo str_pad($resident->Rooms, 8)
         . str_pad($resident->first_name . " " . $resident->last_name, 26)
         . str_pad(round($resident->getCurrentBillAmount(), 2) . 'EUR', 16);
         
    if(isset($lockSuccessful[$resident->getId()])) {
        if($lockSuccessful[$resident->getId()] == true) {
            echo str_pad("Erfolgreich", 30);
        } else {
            echo str_pad("FEHLGESCHLAGEN", 30);
        }
    } elseif(isset($resetSuccessful[$resident->getId()])) {
        if($resetSuccessful[$resident->getId()] == true) {
            echo str_pad("Zurückgesetzt", 30);
        } else {
            echo str_pad("Zurücksetzen fehlgeschlagen!", 30);
        }
    } else {
        echo str_pad("Kein Sperrversuch?", 30);
    }

    echo PHP_EOL;
}
?>

Bitte analoge Telefone, bei denen das automatische Sperren fehlschlug, von Hand sperren.

SIP-Telefone müssen nicht in der Datenbank und dürfen nicht mittels phone-access gesperrt werden.
SIP-Telefone sollten zurückgesetzt werden. Wenn dies fehlgeschlagen ist bitte im Frontend das Telefon manuell komplett zurücksetzen.

Die Rechnungen werden beim nächsten Rechnungserstellen ganz normal vom angegebenen Konto abgebucht.

---
Das war der Task: 'hekphone:check-residents-moving-out' mit den Optionen --notify-team --lock --reset-phone --warn-resident. Via cronjob von hekphone@hekphone.
