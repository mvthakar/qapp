<?php

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['UserType'] != 'Admin') {
    header('Location: ./index.php');
    exit();
}

