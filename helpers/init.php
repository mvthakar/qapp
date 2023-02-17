<?php

date_default_timezone_set('Asia/Kolkata');

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");

define("BASE_DIR", $_SERVER['DOCUMENT_ROOT'] . "/qapp");
define("BASE_URL", "/qapp");

function pathOf($path)
{
    return BASE_DIR . "/" . $path;
}

function urlOf($path)
{
    return BASE_URL . '/' . $path;
}

function getRequestBody()
{
    $jsonString = file_get_contents("php://input");
    return json_decode($jsonString);
}

require_once pathOf('helpers/database.php');
require_once pathOf('helpers/validations.php');
