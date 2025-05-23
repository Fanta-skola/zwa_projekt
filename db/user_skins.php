<?php
function adduskin($db, $user,$skin) {

    $stmt = mysqli_prepare($db, "
        INSERT INTO user_skins
        (id_user, id_skin)
        VALUES
        (?, ?)
    ");
    if ($stmt === false) {
        echo "<p>Nastala chyba s přidáním skinu</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }
    mysqli_stmt_bind_param($stmt, "ii", $user,$skin);
    $result = mysqli_execute($stmt);

    if ($result === false) {
        echo "<p>Nastala chyba s přidáním skinu</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }
}

function getuskin($db, $id) {
    $stmt = mysqli_prepare($db, "
        SELECT * FROM user_skins
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

function listuskins($db) {
    $result = mysqli_query($db, "
        SELECT user_skins.*, skins.name AS skin_name, users.username AS user_name
FROM user_skins
LEFT JOIN skins ON user_skins.id_skin = skins.id
LEFT JOIN users ON user_skins.id_user = user.id
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

function edituskin($db,$id, $user, $skin) {
    $stmt = mysqli_prepare($db, "
        UPDATE user_skins
        SET id_user = ?, id_skin = ?
        WHERE id = ?
    ");
    if ($stmt === false) {
        echo "<p>Nastala chyba s upravením skinu</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }
    mysqli_stmt_bind_param($stmt, "iii", $user,$skin, $id);
    $result = mysqli_execute($stmt);

    if ($result === false) {
        echo "<p>Nastala chyba s upravením skinu</p>";
        echo "<p>" . mysqli_error($db) . "</p>";
        exit;
    }
}

function deleteuskin($db, $id) {
    $stmt = mysqli_prepare($db, "
        DELETE FROM user_skins
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

function listuserskin($db) {
    $result = mysqli_query($db, "SELECT * FROM guns");
    if ($result === false) {
        echo "<p>Chyba při načítání typů zbraní</p>";
        return [];
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}