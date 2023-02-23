<?php

require '../../helpers/init.php';
allowedMethods(['POST']);

if (!isset($_FILES['dp'])) {
    http_response_code(400);
    jsonResponseAndDie(["message" => "Incomplete data"]);
}

$userId = $_GET['userId'];

$uploadDir = pathOf('uploads/display-pictures');
$tempFileName = $_FILES['dp']['tmp_name'];
$actualFileName = time() . "-{$_FILES['dp']['name']}";

move_uploaded_file($tempFileName, "$uploadDir/$actualFileName");
execute("UPDATE `Profiles` SET `DisplayPicture` = ? WHERE `UserId` = ?", [$actualFileName, $userId]);
