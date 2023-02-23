<?php

require_once "../../helpers/init.php";
require_once pathOf('admin/helpers/is-admin.php');

try
{
    execute("UPDATE `Categories` SET `IsDeleted` = 1 WHERE `Id` = ?", [$_GET['id']]);
}
finally
{
    header('Location: ' . urlOf('admin/categories'));
}

