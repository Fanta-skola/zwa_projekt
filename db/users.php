<?php

$imageFolder = "user-images";

function registerUser($db, $username, $password) {

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $stmt = mysqli_prepare($db, "
        INSERT INTO users
        (username, password)
        VALUES
        (?, ?)
    ");
    if ($stmt === false) {
        echo "<p>Nastala chyba s vytvořením uživatele</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }
    mysqli_stmt_bind_param($stmt, "ss", $username, $hashedPassword);
    $result = mysqli_execute($stmt);

    if ($result === false) {
        echo "<p>Nastala chyba s vytvořením uživatele</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }
}

function getUser($db, $username) {
    $stmt = mysqli_prepare($db, "
        SELECT * FROM users
        WHERE username = ?
    ");
    if ($stmt === false) {
        echo "<p>Nastala chyba se získáním uživatele</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }
    mysqli_stmt_bind_param($stmt, "s", $username);
    $result = mysqli_execute($stmt);

    if ($result === false) {
        echo "<p>Nastala chyba se získáním uživatele</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }

    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

function login($db, $username, $password) {
    $user = getUser($db, $username);
    if ($user === null || !password_verify($password, $user["password"])) {
        echo "<p>Neplatné přihlašovací údaje</p>";
        return;
    }
    echo "<p>Úspěšné přihlášení!</p>";
    $_SESSION["loggedInUser"] = $user;
}