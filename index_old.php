<?php

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=5");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec($ch);
curl_close ($ch);
die($server_output);



$name = $_GET['name'] ?? "Viktor";
$age = $_GET['age'] ?? 25;

$ch = curl_init();
//Set url for request
curl_setopt($ch, CURLOPT_URL, "http://localhost/api/api.php");
//Set request METHOD TO POST
curl_setopt($ch, CURLOPT_POST, 1);
//WILL WAIT FOR RESPONSE BODY
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//SEND POST FIELDS
curl_setopt(
    $ch,
    CURLOPT_POSTFIELDS,
    "name=$name&age=$age");
//MAKE REQUEST AND set response body to $RES variable
$res = curl_exec($ch);
die($res);


//curl_setopt($ch, CURLOPT_POST, 1);
//curl_setopt($ch, CURLOPT_POSTFIELDS,
//    "postvar1=value1&postvar2=value2&postvar3=value3");

// In real life you should use something like:
// curl_setopt($ch, CURLOPT_POSTFIELDS,
//          http_build_query(array('postvar1' => 'value1')));

// Receive server response ...