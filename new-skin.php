<?php

require "./utils/init.php";
require "./db/skins.php";

if (!isset($_SESSION["loggedInUser"])) {
    header("Location: /Projekt");
    exit;
}

if (isset($_POST["newskin"])) {
    addskin($db, $_POST["name"], $_POST["skin"], $_FILES["image"]);
}

require "./layout/head.phtml";
require "./new-skin.phtml";
require "./layout/tail.phtml";