<?php

require '../../helpers/init.php';

allowedMethods(['GET']);

if (isset($_GET['id'])) {
    $categories = selectOne("SELECT `Id`, `Name` FROM `Categories` WHERE `Id` = ? AND `IsDeleted` = 0", [$_GET['id']]);
    jsonResponse($categories);
} else {
    $categories = select("SELECT `Id`, `Name` FROM `Categories` WHERE `IsDeleted` = 0");
    jsonResponse($categories);
}
