<?php

$imageFolder = "gun-img";

function addgun($db, $name, $price, $type, $image) {
    global $imageFolder;

    $imagePath = null;
    if ($image["error"] !== UPLOAD_ERR_NO_FILE) {
        if ($image["error"] !== UPLOAD_ERR_OK) {
            echo "<p>Nastala chyba při nahraní náhledu</p>";
            return;
        }

        if (!str_starts_with($image["type"], "image/")) {
            echo "<p>Lze nahrát pouze obrázky</p>";
            return;   
        }

        if (!file_exists($imageFolder)) {
            mkdir($imageFolder);
        }

        $imagePath = $imageFolder . "/" . uniqid() . $image["name"];
        move_uploaded_file($image["tmp_name"], $imagePath);
    }

    $stmt = mysqli_prepare($db, "
        INSERT INTO guns
        (type, name, img, Price)
        VALUES
        (?, ?, ?, ?)
    ");
    if ($stmt === false) {
        echo "<p>Nastala chyba s přidáním zbraně</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }
    mysqli_stmt_bind_param($stmt, "sssi", $type, $name, $imagePath, $price);
    $result = mysqli_execute($stmt);

    if ($result === false) {
        echo "<p>Nastala chyba s přidáním zbraně</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }
}

function getgun($db, $id) {
    $stmt = mysqli_prepare($db, "
        SELECT * FROM guns
        WHERE id = ?
    ");
    if ($stmt === false) {
        echo "<p>Nastala chyba se získáním zbraně</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }
    mysqli_stmt_bind_param($stmt, "i", $id);
    $result = mysqli_execute($stmt);

    if ($result === false) {
        echo "<p>Nastala chyba se získáním zbraně</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }

    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

function listgun($db) {
    $result = mysqli_query($db, "
        SELECT *
        FROM guns
        ORDER BY id ASC;
    ");
    if ($result === false) {
        echo "<p>Nastala chyba se získáním zbraně</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        return [];
    } else {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

function editgun($db, $id,$type, $name, $price, $image) {
    global $imageFolder;

    $imagePath = null;
    if ($image["error"] !== UPLOAD_ERR_NO_FILE) {
        if ($image["error"] !== UPLOAD_ERR_OK) {
            echo "<p>Nastala chyba při nahrávání obrázku</p>";
            return;
        }

        if (!str_starts_with($image["type"], "image/")) {
            echo "<p>Lze nahrát pouze obrázky</p>";
            return;   
        }

        if (!file_exists($imageFolder)) {
            mkdir($imageFolder);
        }

        $imagePath = $imageFolder . "/" . uniqid() . $image["name"];
        move_uploaded_file($image["tmp_name"], $imagePath);
    }

    $stmt = mysqli_prepare($db, "
        UPDATE guns
        SET name = ?,type = ?, price = ?, img = ?
        WHERE id = ?
    ");
    if ($stmt === false) {
        echo "<p>Nastala chyba s upravením zbraně</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }
    mysqli_stmt_bind_param($stmt, "ssisi", $name,$type, $price, $imagePath, $id);
    $result = mysqli_execute($stmt);

    if ($result === false) {
        echo "<p>Nastala chyba s upravením zbraně</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }
}

function deletegun($db, $id) {
    $stmt = mysqli_prepare($db, "
        DELETE FROM guns
        WHERE id = ?
    ");
    if ($stmt === false) {
        echo "<p>Nastala chyba s vymazáním zbraně</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }
    mysqli_stmt_bind_param($stmt, "i", $id);
    $result = mysqli_execute($stmt);

    if ($result === false) {
        echo "<p>Nastala chyba s vymazáním zbraně</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }
}
