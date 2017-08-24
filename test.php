<?php
/**
 * Created by PhpStorm.
 * User: mbugla
 * Date: 19.08.2017
 * Time: 12:22
 */
$url = "http://gw.mobilant.com"; // URL des Gateways
$request = ""; // Request Variable initialisieren
$param["key"] = "2SwMZp53449d19S0Aue1j7U"; // Gateway Key
$param["to"] = "48506456683"; // Empfänger der SMS
$param["message"] = "test msg"; // Inhalt der Nachricht
$param["route"] = "gold";// Nutzung der Goldroute
$param["from"] = "PREMIUM";// Absender der SMS

foreach ($param as $key => $val) // Alle Parameter durchlaufen
{
    $request .= $key."=".urlencode($val); // Werte müssen url-encoded sein
    $request .= "&"; // Trennung der Parameter mit &
}

// SMS kann jetzt versendet werden

$ch = curl_init(); //initialize curl handle
curl_setopt($ch, CURLOPT_URL, $url); //set the url
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //return as a variable
curl_setopt($ch, CURLOPT_POST, 1); //set POST method
curl_setopt($ch, CURLOPT_POSTFIELDS, $request); //set the POST variables
$response = curl_exec($ch); //run the whole process and return the response
curl_close($ch); //close the curl handle

$responseCode = intval($response);

echo $responseCode;
