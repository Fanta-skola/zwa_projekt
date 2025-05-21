<?php

require "./utils/init.php";
require "./db/guns.php";

if (isset($_POST["deletegun"])) {
    if (!isset($_SESSION["loggedInUser"])) {
        header("Location: /zwa_projekt");
        exit;
    }
    deletegun($db, $_POST["id"]);
}

if (isset($_POST["editgun"])) {
    if (!isset($_SESSION["loggedInUser"])) {
        header("Location: /zwa_projekt");
        exit;
    }
    editgun(
        $db,
        $_GET["id"],
        $_POST["name"], 
        $_POST["price"],
        $_FILES["image"]
    );
}

require "./layout/head.phtml";

if (isset($_GET["id"])) {
    $gun = getgun($db, $_GET["id"]);
    require "./edit-gun.phtml";
} else {
    $gun = listgun($db);
    require "./guns.phtml";
}

require "./layout/tail.phtml";