<?php

require "./utils/init.php";
require "./db/skins.php";

if (isset($_POST["deleteskin"])) {
    if (!isset($_SESSION["loggedInUser"])) {
        header("Location: /zwa_projekt");
        exit;
    }
    deleteskin($db, $_POST["id"]);
}

if (isset($_POST["editskin"])) {
    if (!isset($_SESSION["loggedInUser"])) {
        header("Location: /zwa_projekt");
        exit;
    }
    editskin(
        $db,
        $_GET["id"],
        $_POST["name"], 
        $_POST["type"],
        $_POST["price"],
        $_FILES["image"]
    );
}

require "./layout/head.phtml";

if (isset($_GET["id"])) {
    $skin = getskin($db, $_GET["id"]);
    require "./edit-skin.phtml";
} else {
    $skins = listskins($db);
    require "./skins.phtml";
}

require "./layout/tail.phtml";