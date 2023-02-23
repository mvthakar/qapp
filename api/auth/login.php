<?php

require '../../helpers/init.php';
allowedMethods(['POST']);

$request = getRequestBody();

if (!isset($request->email) || !isset($request->password)) {
    http_response_code(400);
    jsonResponseAndDie(["message" => "Incomplete data"]);
}

$email = $request->email;
$password = $request->password;

if (!validateEmail($email)) {
    http_response_code(400);
    jsonResponseAndDie(["message" => "Invalid email!"]);
}

$user = selectOne("SELECT * FROM `Users` WHERE `Email` = ?", [$email]);
if ($user == null || !password_verify($password, $user['PasswordHash'])) {
    http_response_code(403);
    jsonResponseAndDie(["message" => "Wrong email or password!"]);
}

jsonResponse(["id" => $user["Id"]]);
