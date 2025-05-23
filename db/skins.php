<?php

$imageFolder = "skins-img";

function addskin($db, $name,$type, $price, $image) {
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
        INSERT INTO skins
        (name, type, price, img)
        VALUES
        (?, ?, ?, ?)
    ");
    if ($stmt === false) {
        echo "<p>Nastala chyba s přidáním skinu</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }
    mysqli_stmt_bind_param($stmt, "siis", $name,$type, $price, $imagePath);
    $result = mysqli_execute($stmt);

    if ($result === false) {
        echo "<p>Nastala chyba s přidáním skinu</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }
}

function getskin($db, $id) {
    $stmt = mysqli_prepare($db, "
        SELECT * FROM skins
        WHERE id = ?
    ");
    if ($stmt === false) {
        echo "<p>Nastala chyba se získáním skinu</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }
    mysqli_stmt_bind_param($stmt, "i", $id);
    $result = mysqli_execute($stmt);

    if ($result === false) {
        echo "<p>Nastala chyba se získáním skinu</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }

    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

function listskins($db) {
    $result = mysqli_query($db, "
        SELECT skins.*, guns.name AS type_name
FROM skins
LEFT JOIN guns ON skins.type = guns.id
ORDER BY skins.id ASC;
    ");
    if ($result === false) {
        echo "<p>Nastala chyba se získáním skinu</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        return [];
    } else {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

function editskin($db,$id, $name,$type, $price, $image) {
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
        UPDATE skins
        SET name = ?,type = ?, price = ?, img = ?
        WHERE id = ?
    ");
    if ($stmt === false) {
        echo "<p>Nastala chyba s upravením skinu</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }
    mysqli_stmt_bind_param($stmt, "siisi", $name,$type, $price, $imagePath, $id);
    $result = mysqli_execute($stmt);

    if ($result === false) {
        echo "<p>Nastala chyba s upravením skinu</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }
}

function deleteskin($db, $id) {
    $stmt = mysqli_prepare($db, "
        DELETE FROM skins
        WHERE id = ?
    ");
    if ($stmt === false) {
        echo "<p>Nastala chyba s vymazáním skinu</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }
    mysqli_stmt_bind_param($stmt, "i", $id);
    $result = mysqli_execute($stmt);

    if ($result === false) {
        echo "<p>Nastala chyba s vymazáním skinu</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }
}

function listguntype($db) {
    $result = mysqli_query($db, "SELECT * FROM guns");
    if ($result === false) {
        echo "<p>Chyba při načítání typů zbraní</p>";
        return [];
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}