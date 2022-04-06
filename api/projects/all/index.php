<?php

$config = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/data/projects.json"), true);
header("Content-Type: application/json");
die(json_encode($config));