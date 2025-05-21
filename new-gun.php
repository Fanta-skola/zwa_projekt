<?php

require "./utils/init.php";
require "./db/guns.php";

if (!isset($_SESSION["loggedInUser"])) {
    header("Location: /zwa_projekt");
    exit;
}

if (isset($_POST["newgun"])) {
    addskin($db, $_POST["name"], $_POST["gun"], $_FILES["image"]);
}

require "./layout/head.phtml";
require "./new-gun.phtml";
require "./layout/tail.phtml";