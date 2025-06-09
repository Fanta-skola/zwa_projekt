<?php

require "./utils/init.php";
require "./db/user_skins.php";
require "./db/skins.php"; 
require "./db/users.php";

if (isset($_POST["deleteuskin"])) {
    if (!isset($_SESSION["loggedInUser"])) {
        header("Location: /zwa_projekt");
        exit;
    }
    deleteuskin($db, $_POST["id"]);
}

if (isset($_POST["edituskin"])) {
    if (!isset($_SESSION["loggedInUser"])) {
        header("Location: /zwa_projekt");
        exit;
    }
    edituskin(
        $db,
        $_GET["id"],
        $_POST["skin"],
    );
}

require "./layout/head.phtml";

if (isset($_GET["id"])) {
   $uskin = getuskin($db, $_GET["id"]);
    $skins = listskins($db);
    require "./edit-uskin.phtml";
} else {
    $uskins = listuskins($db);
    require "./user_skins.phtml";
}

require "./layout/tail.phtml";