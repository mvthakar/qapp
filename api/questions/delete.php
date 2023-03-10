<?php

require '../../helpers/init.php';

allowedMethods(['POST']);
$request = mustBeLoggedIn();

if (!isset($request->id)) {
    http_response_code(400);
    jsonResponseAndDie(["message" => "Incomplete data"]);
}

$id = $request->id;
execute("UPDATE `Questions` SET `IsDeleted` = ? WHERE `Id` = ?", [1, $id]);
