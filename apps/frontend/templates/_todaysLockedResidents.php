Folgende Bewohner sind gestern ausgezogen:
<?php
// table header
echo str_pad('Zimmer', 8)
     . str_pad('Vorname, Nachname', 26)
     . str_pad('Aktion', 46) . PHP_EOL
     . str_pad('', 80, '-') . PHP_EOL;

//table body
foreach($residentsMovingOut as $resident) {
    echo str_pad($resident->Rooms, 8)
         . str_pad($resident->first_name . " " . $resident->last_name, 26);
         
    if(isset($lockSuccessful[$resident->getId()])) {
        if($lockSuccessful[$resident->getId()] == true) {
            echo str_pad("Sperren in Anlage: Erfolgreich", 46);
        } else {
            echo str_pad("Sperren in Anlage: Fehlgeschlagen", 46);
        }
    } elseif(isset($resetSuccessful[$resident->getId()])) {
        if($resetSuccessful[$resident->getId()] == true) {
            echo str_pad("Telefon zurücksetzen: Erfolgreich", 46);
        } else {
            echo str_pad("Telefon zurücksetzen: Fehlgeschlagen", 46);
        }
    } else {
        echo str_pad("Kein Sperrversuch?", 46);
    }

    echo PHP_EOL;
}
?>

Bitte analoge Telefone, bei denen das automatische Sperren fehlschlug, von Hand mit phone-access -1xxx sperren.

SIP-Telefone müssen nicht in der Datenbank und dürfen nicht mittels phone-access gesperrt werden.
SIP-Telefone sollten zurückgesetzt werden. Wenn dies fehlgeschlagen ist bitte im Frontend das Telefon manuell komplett zurücksetzen.

Eventuelle offene Rechnungen werden beim nächsten Rechnungserstellen ganz normal vom angegebenen Konto abgebucht.

---
Das war der Task: 'hekphone:check-residents-moving-out' mit den Optionen --notify-team --lock --reset-phone --warn-resident. Via cronjob von hekphone@hekphone.
