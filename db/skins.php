<?php

$imageFolder = "skins-img";

function addskin($db, $name, $price, $image) {
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
        (name, price, img)
        VALUES
        (?, ?, ?)
    ");
    if ($stmt === false) {
        echo "<p>Nastala chyba s přidáním skinu</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }
    mysqli_stmt_bind_param($stmt, "sis", $name, $price, $imagePath);
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
        SELECT *
        FROM skins
        ORDER BY id ASC;
    ");
    if ($result === false) {
        echo "<p>Nastala chyba se získáním skinu</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        return [];
    } else {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

function editskin($db, $id, $name, $price, $image) {
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
        SET name = ?, price = ?, img = ?
        WHERE id = ?
    ");
    if ($stmt === false) {
        echo "<p>Nastala chyba s upravením skinu</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }
    mysqli_stmt_bind_param($stmt, "sisi", $name, $price, $imagePath, $id);
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
