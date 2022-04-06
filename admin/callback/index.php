<?php

if (!isset($_GET['code'])) {
    throw new ErrorException("GitHub OAuth Flow interrupted", 214, E_ERROR);
}

$data = array(
    'client_id' => json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/github.json"), true)["id"],
    'client_secret' => json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/github.json"), true)["secret"],
    'code' => $_GET['code']
);

$post_data = json_encode($data);

$crl = curl_init('https://github.com/login/oauth/access_token');
curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($crl, CURLINFO_HEADER_OUT, true);
curl_setopt($crl, CURLOPT_POST, true);
curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);

curl_setopt($crl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    "Accept: application/json"
));

$result = curl_exec($crl);

if ($result === false) {
    throw new ErrorException("GitHub OAuth Flow interrupted", 214, E_ERROR);
}

curl_close($crl);

$data = json_decode($result, true);
$crl = curl_init('https://api.github.com/user');
curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($crl, CURLINFO_HEADER_OUT, true);
curl_setopt($crl, CURLOPT_POST, false);

curl_setopt($crl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    "Accept: application/json",
    "Authorization: token " . $data["access_token"],
    "User-Agent: ProjectCloudsdale-Admin/0.0.0 (contact@minteck.org)"
));

$result = curl_exec($crl);
$ndata = json_decode($result, true);

if (!in_array($ndata["login"], json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/admins.json"), true))) {
    header("Location: /");
    die();
}

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens")) mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/tokens");
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $data["access_token"], $ndata["login"]);
setcookie("pcdAdminToken", $data["access_token"], 0, "/");

header("Location: /admin");
die();
