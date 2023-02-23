<?php

function mustBeLoggedIn()
{
    $request = getRequestBody();
    if (!isset($request->userId)) {
        http_response_code(403);
        exit();
    }

    return $request;
}

function mustBeAdmin()
{
    $request = getRequestBody();
    
    if (!isset($request->userId)) {
        http_response_code(403);
        exit();
    }

    $user = getLoggedInUser();
    if ($user['UserType'] != 'A') {
        http_response_code(401);
        exit();
    }

    return $request;
}

function getLoggedInUser()
{
    $request = getRequestBody();
    $user = selectOne("SELECT `Id`, `Email`, `UserType` FROM `Users` WHERE `Id` = ?", [$request->userId]);

    if ($user == null) {
        http_response_code(403);
        exit();
    }

    return $user;
}

function allowedMethods($methods)
{
    array_push($methods, 'OPTIONS');
    $currentMethod = $_SERVER['REQUEST_METHOD'];

    if (!in_array($currentMethod, $methods)) {
        http_response_code(405);
        exit();
    }
}

function validateEmail($email) {
    $pattern = '/^([A-Za-z0-9]+[\.\-_]?)+[A-Za-z0-9]+@([A-Za-z0-9]+[\.\-]?)+[A-Za-z0-9]+\.[A-Za-z]+$/';
    return preg_match($pattern, $email);
}