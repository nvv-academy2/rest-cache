<?php

require_once ("vendor/autoload.php");

const WEATHER_FILE = "weather.json";

$client = new \GuzzleHttp\Client();


buildCurrencyTable(getCurrency());
buildWeather(getWeather());





function getCache(string $key, $default = null)
{
    if (!file_exists($key)) {
        return $default;
    }

    $data = json_decode(file_get_contents($key), true);
    if (time() > $data['ttl']) {
        unlink($key);
        return $default;
    }

    return $data['data'];
}


function setCache(string $key, $data, $cacheTTL = 15)
{
    $config = [
        'data' => $data,
        'ttl' => time() + $cacheTTL
    ];
    return (bool) file_put_contents($key, json_encode($config));
}




function getWeather()
{
    global $client;
    $data = getCache(WEATHER_FILE);
    if ($data) {
        echo "FROM CACHE!</br>";
        return $data;
    }
    echo "GET WEATHER FROM API</br>";
    $res = $client->get("https://api.openweathermap.org/data/2.5/weather?q=Kiev&apiKey=da81f9076bedcbdba0e11636eedfb984");
    $weather = json_decode($res->getBody()->getContents(), true)['main'];
    setCache(WEATHER_FILE, $weather);
    return $weather;
}


function getCurrency()
{
    global $client;
    $res = $client->get("https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=5");
    $data = json_decode($res->getBody()->getContents(), true);

    unset($data[3]);
    return $data;
}

function buildCurrencyTable(array $data)
{
    $html = "<table border='1'>";

    $html .= "<thead><th>Sale</th><th>Currency</th><th>Buy</th></thead><tbody>";

    foreach ($data as $row) {
        $html .= "<tr>";
        $html .= "<td>" . $row['buy'] . "</td>";
        $html .= "<td>" . $row['ccy'] . "</td>";
        $html .= "<td>" . $row['sale'] . "</td>";
        $html .= "</tr>";
    }
    $html .= "</tbody></table>";

    echo $html;
}


function buildWeather(array $weather)
{
    $html = "<table border='1'>
<thead>
<th colspan='2'>Weather</th>
</thead><tbody>";

    $html .= "<tr><td>Temperature (C)</td><td>" . ($weather['temp'] - 273.15) . "</td></tr>";
    $html .= "<tr><td>Humidity (C)</td><td>" . ($weather['humidity'] ) . "% </td></tr>";
    $html .= "<tr><td>Min (C)</td><td>" . ($weather['temp_min'] - 273.15) . "</td></tr>";
    $html .= "<tr><td>Max (C)</td><td>" . ($weather['temp_max'] - 273.15) . "</td></tr>";

    $html .= "</tbody></table>";

    echo $html;
}



/*
$client = new \GuzzleHttp\Client();
$res = $client->get("https://api.privatbank.ua/p24api/pubinfo?exchange&coursid=5");
$xml = $res->getBody();
$exchangerates = new SimpleXMLElement($xml->getContents());
echo $exchangerates->row[0];

*/