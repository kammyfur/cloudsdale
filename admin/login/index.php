<?php

header("Location: https://github.com/login/oauth/authorize?client_id=" . json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/github.json"), true)["id"] . "&redirect_uri=http://$_SERVER[HTTP_HOST]/admin/callback/&allow_signups=false&scope=read:user");
die();
