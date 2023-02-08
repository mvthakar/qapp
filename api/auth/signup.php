<?php

require '../../helpers/init.php';

$request = getRequestBody();
if (!isset($request->email) || !isset($request->password))
{
    http_response_code(400);
    die(json_encode(["message" => "Incomplete data"]));
}

$email = $request->email;
$password = $request->password;

$user = selectOne("SELECT * FROM `Users` WHERE `Email` = ?", [$email]);
if ($user != null)
{
    http_response_code(409);
    die(json_encode(["message" => "Email already registered!"]));
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);
execute("INSERT INTO `Users` SET `Email` = ?, `PasswordHash` = ?, `Isverified` = ?, `UserRoleId` = ?", [$email, $passwordHash, 0, 2]);

http_response_code(201);
