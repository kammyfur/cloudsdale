<?php

global $_USER;
$admin = true;
if (!isset($_COOKIE["pcdAdminToken"])) {
    $admin = false;
    if (isset($__ADMIN)) header("Location: /admin/login") and die();
} else {
    if (!(!str_contains("/", $_COOKIE['pcdAdminToken']) && !str_contains(".", $_COOKIE['pcdAdminToken']) && (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['pcdAdminToken'])))) {
        $admin = false;
        if (isset($__ADMIN)) header("Location: /admin/login") and die();
    } else {
        $_USER = trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['pcdAdminToken']));
    }
}
