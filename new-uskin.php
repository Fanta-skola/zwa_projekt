<?php

require "./utils/init.php";
require "./db/user_skins.php";
require "./db/skins.php";

if (!isset($_SESSION["loggedInUser"])) {
    header("Location: /zwa_projekt");
    exit;
}
$skins = listskins($db); 
if (isset($_POST["newuskin"])) {
    $userId = $_SESSION["loggedInUser"]["id"];
    $skinId = $_POST["skin"];
    adduskin($db, $userId, $skinId);
    header("Location: /zwa_projekt/user_skins.php"); 
    exit;
}
require "./layout/head.phtml";
require "./new-uskin.phtml";
require "./layout/tail.phtml";
