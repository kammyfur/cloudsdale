<?php

$config = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/data/pluralkit.json"), true);
header("Content-Type: application/json");
die(file_get_contents("https://api.pluralkit.me/v2/systems/$config[system]/count"));