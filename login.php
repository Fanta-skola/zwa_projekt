<?php

require "./utils/init.php";
require "./db/users.php";

if (isset($_POST["loginForm"])) {
    login($db, $_POST["username"], $_POST["password"]);
}

require "./layout/head.phtml";
require "./login.phtml";
require "./layout/tail.phtml";