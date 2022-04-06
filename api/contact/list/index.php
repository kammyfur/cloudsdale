<?php

$config = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/data/projects.json"), true);
$listed = [];
header("Content-Type: application/json");

foreach ($config as $project) {
    unset($project["showcase"]);
    $listed[] = $project;
}

die(json_encode($listed));