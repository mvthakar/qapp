<?php

require '../../helpers/init.php';

allowedMethods(['POST']);
$request = mustBeAdmin();

if (!isset($request->id)) {
    http_response_code(400);
    die(json_encode(["message" => "Incomplete data"]));
}

$id = $request->id;
$category = selectOne("SELECT * FROM `Categories` WHERE `Id` = ?", [$id]);

if ($category == null) {
    http_response_code(404);
    die(json_encode(["message" => "Category doesn't exist!"]));
}

execute("UPDATE `Categories` SET `IsDeleted` = ? WHERE `Id` = ?", [1, $id]);
