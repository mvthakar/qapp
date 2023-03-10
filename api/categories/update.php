<?php

require '../../helpers/init.php';

allowedMethods(['POST']);
$request = mustBeAdmin();

if (!isset($request->id) || !isset($request->name)) {
    http_response_code(400);
    jsonResponseAndDie(["message" => "Incomplete data"]);
}

$id = $request->id;
$name = htmlspecialchars($request->name);

$category = selectOne("SELECT * FROM `Categories` WHERE `Id` = ?", [$id]);
if ($category == null) {
    http_response_code(404);
    jsonResponseAndDie(["message" => "Category does not exist!"]);
}

execute("UPDATE `Categories` SET `Name` = ? WHERE `Id` = ?", [$name, $id]);
