<?php

require '../../helpers/init.php';

allowedMethods(['POST']);
$request = mustBeAdmin();

if (!isset($request->name)) {
    http_response_code(400);
    jsonResponseAndDie(["message" => "Incomplete data"]);
}

$name = htmlspecialchars($request->name);

$category = selectOne("SELECT * FROM `Categories` WHERE `Name` = ?", [$name]);
if ($category != null) {
    http_response_code(409);
    jsonResponseAndDie(["message" => "Category already exists."]);
}

execute("INSERT INTO `Categories` SET `Name` = ?", [$name]);
