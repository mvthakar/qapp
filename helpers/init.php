<?php

define("BASE_DIR", $_SERVER['DOCUMENT_ROOT'] . "/qapp");
define("BASE_URL", "/qapp");

// define("BASE_DIR", $_SERVER['DOCUMENT_ROOT'] . "");
// define("BASE_URL", "");

date_default_timezone_set('Asia/Kolkata');
$connection = new PDO(
    "mysql:host=localhost;port=3306;dbname=QApp", 
    "root", 
    ""
);

function pathOf($path)
{
    return BASE_DIR . "/" . $path;
}

function urlOf($path)
{
    return BASE_URL . '/' . $path;
}

function execute($query, $params = null)
{
    global $connection;
    
    $statement = $connection->prepare($query);
    return $statement->execute($params);
}

function selectOne($query, $params = null)
{
    global $connection;

    $statement = $connection->prepare($query);
    $statement->execute($params);

    $row = $statement->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function select($query, $params = null)
{
    global $connection;

    $statement = $connection->prepare($query);
    $statement->execute($params);

    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

function lastInsertId()
{
    global $connection;
    return $connection->lastInsertId();
}

function getLastError()
{
    global $connection;
    return $connection->errorInfo();
}

function getRequestBody()
{
    $jsonString = file_get_contents("php://input");
    return json_decode($jsonString);
}

function mustBeLoggedIn()
{
    $request = getRequestBody();
    if (!isset($request->userId))
    {
        http_response_code(403);
        exit();
    }
}

function getLoggedInUser()
{
    $request = getRequestBody();
    return selectOne("SELECT `Email`, `UserRoleId` FROM `Users` WHERE `Id` = ?", [$request->userId]);
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");
