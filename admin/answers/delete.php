<?php

require_once "../../helpers/init.php";
require_once pathOf('admin/helpers/is-admin.php');

try
{
    $id = $_GET['id'];
    $questionId = $_GET['questionId'];

    execute("UPDATE `Answers` SET `IsDeleted` = 1 WHERE `Id` = ?", [$id]);
    header('Location: ' . urlOf("admin/answers/?questionId=$questionId"));
}
catch (Exception $ex)
{
    header('Location: ' . urlOf('admin/questions'));
}

