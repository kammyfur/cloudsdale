<?php

function isSecure() {
    return
        (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || $_SERVER['SERVER_PORT'] == 443;
}


header("Location: https://github.com/login/oauth/authorize?client_id=" . json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/github.json"), true)["id"] . "&redirect_uri=http" . (isSecure() ? "s"  : "") . "://$_SERVER[HTTP_HOST]/admin/callback/&allow_signups=false&scope=read:user");
die();
