<?php

require "./utils/init.php";
require "./db/skins.php";

if (!isset($_SESSION["loggedInUser"])) {
    header("Location: /zwa_projekt");
    exit;
}
$type = listguntype($db);

if (isset($_POST["newskin"])) {
    addskin($db, $_POST["name"],$_POST["type"], $_POST["price"], $_FILES["image"]);
}

require "./layout/head.phtml";
require "./new-skin.phtml";
require "./layout/tail.phtml";