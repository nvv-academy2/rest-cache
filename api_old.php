<?php



$name = $_POST['name'] ?? "";
$age = $_POST['age'] ?? '';
$str = "Name: $name".PHP_EOL."Age: $age" . PHP_EOL . "Date: " . date("Y-m-d H:i:s") . PHP_EOL;

die(
    json_encode(
        [
            "status" => (bool) file_put_contents("index.txt", $str, FILE_APPEND)
        ]
    )
);