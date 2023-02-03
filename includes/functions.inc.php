<?php

function emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat) {
    $result;
    if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidUid($username) {
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email) {
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRepeat) {
    $result;
    if ($pwd !== $pwdRepeat) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function uidExists($conn, $username, $email) {
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);

}

function createUser($conn, $name, $email, $username, $pwd) {
    $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd) VALUES (?, ?, ?, ?);";

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    sql_execute($sql, "ssss", [$name, $email, $username, $hashedPwd], true);
    
    header("location: ../signup.php?error=none");
    exit();
}

function emptyInputLogin($username, $pwd) {
    $result;
    if (empty($username) || empty($pwd)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $username, $pwd) {
    $uidExists = uidExists($conn, $username, $username);

    if ($uidExists === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["usersPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    else if ($checkPwd === true) {
        session_start();
        $_SESSION["userid"] = $uidExists["usersId"];
        $_SESSION["useruid"] = $uidExists["usersUid"];
        $_SESSION["useremail"] = $uidExists["usersEmail"];
        header("location: ../index.php");
        exit();
    }
}

function searchReis($conn, $stad, $activiteit, $minprijs, $maxprijs, $duur) {
    $sql = "SELECT * FROM reis WHERE reisStad LIKE ? AND reisActiviteit LIKE ? AND reisPrijs >= ? AND reisPrijs <= ? AND reisDuur LIKE ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    // echo "In searchReis $stad, $activiteit, $prijsMax, $duur";
    // stop;
    mysqli_stmt_bind_param($stmt, "sssss", $stad, $activiteit, $minprijs, $maxprijs, $duur);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($rows = mysqli_fetch_all($resultData, MYSQLI_ASSOC)) {
        echo $rows[0]["reisId"];
        //stop;
        return $rows;
    }
    else {
        $result = false;
        echo $results;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function uploadFile($target_file, $file_size, $tmp_name) {
    //session_start();

    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadmsg = "Sorry, your file has not been uploaded because it already exists.";
        return $uploadmsg;
    }

    // Check file size
    if ($file_size > 500000) {
        $uploadmsg = "Sorry, your file has not been uploaded because it is too large.";
        return $uploadmsg;
    }
    echo " Temp ", $tmp_name, " Target ", $target_file;
    //stop;
    if (move_uploaded_file($tmp_name, $target_file)) {
        $uploadmsg = $uploadmsg . " and the file " . htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
        return $uploadmsg;
    } else {
        $uploadmsg = "Sorry, your file has not been uploaded because there was an error uploading your file.";
        print_r($_FILES["fileToUpload"]); // here there should be an "error" https://www.php.net/manual/en/features.file-upload.errors.php
        sstop;
        return $uploadmsg;
    }

    $uploadmsg = "Sorry, something went wrong with the website.";
    return $uploadmsg;
}

function boeken($conn, $usersId, $reisId, $vertrekDatum, $aantalPersonen) {
    $date = date('Y-m-d', getdate()[0]);
    // echo $date;
    // stop;
    $sql = "INSERT INTO boeking (usersId, reisId, boekingAanbetaald, boekingDatumAanbetaald, boekingVertrekDatum, 
    boekingAantalPersonen) VALUES (?, ?, 1, \"$date\", ?, ?);";
    sql_execute($conn, $sql, "ssss", [$usersId, $reisId, $vertrekDatum, $aantalPersonen], true);

    header("location: ../");
    exit();
}

function getTable($conn, $table) {
    //mysql_stmt_bind_param cannot be used for table names
    $sql = "SELECT * FROM " . $table . ";";
    $rows = sql_fetch($conn, $sql, "", "", false);

    if (is_array($rows)) {
        return $rows;
    }
    else {
        $result = false; 
        return $result;
    }
}

function getRows($conn, $tablename, $col, $value) {
    //mysql_stmt_bind_param cannot be used for table names
    $sql = "SELECT * FROM " . $tablename . " WHERE " . $col . " = ?;";
    // echo $sql, $tablename, $col, $value;
    $rows = sql_fetch($conn, $sql, "s", $value, true);

    if (is_array($rows)) {
        return $rows;
    }
    else {
        $result = false; 
        return $result;
    }
}

function getValue($conn, $val, $tablename, $col, $value) {
    //mysql_stmt_bind_param cannot be used for table names
    $sql = "SELECT " . $val . " FROM " . $tablename . " WHERE " . $col . " = ?;";
    $rows = sql_fetch($conn, $sql, "s", $value, true);

    if (is_array($rows)) {
        return $rows;
    }
    else {
        $result = false; 
        return $result;
    }
}

function deleteRow($conn, $tablename, $row) {
    $idname = array_keys($row)[0];
    $id = $row[$idname];
    $sql = "DELETE FROM $tablename WHERE $idname = ?;";
    if ($id) {
        sql_execute($conn, $sql, "s", [$id], true);
    }
}

function updateRow($conn, $tablename, $row) {
    $idname = array_keys($row)[0];
    $id = $row[$idname];
    # Drop the first column (= the id)
    array_shift($row);
    $colnames = array_keys($row); 
    $colvalues = array_values($row);
    array_push($colvalues, "$id");
    $ss = str_repeat("s", count($colvalues));

    $sql = "UPDATE $tablename SET";
    foreach ($colnames as $colname){
        $sql = $sql . " $colname = ?,";
        }
    // remove the last comma and append the WHERE
    $sql = rtrim($sql, ',') . " WHERE $idname = ?;";
    sql_execute($conn, $sql, $ss, $colvalues, true);
}

function insertRow($conn, $tablename, $row) {
    $colnames = array_keys($row); 
    $colvalues = array_values($row);
    $ss = str_repeat("s", count($colvalues));

    $sql = "INSERT $tablename (";
    foreach ($row as $colname => $colvalue){
        $sql = $sql . " $colname,";
    }
    // remove the last comma and append the (?, ?, ...))
    $sql = rtrim($sql, ',') . ") VALUES (" . rtrim(str_repeat("?, ", count($colvalues)), ', ') . ");";

    echo "$sql";
    echo $ss;
    print_r($colvalues);
    //stop;

    sql_execute($conn, $sql, $ss, $colvalues, true);
}

function sql_execute($conn, $sql, $ss, $repl, $bind){
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    if ($bind) {
        mysqli_stmt_bind_param($stmt, $ss, ...$repl);
    }
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
}

function sql_fetch($conn, $sql, $ss, $value, $bind){
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    if ($bind) {
        mysqli_stmt_bind_param($stmt, $ss, $value);
    }
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_all($resultData, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt);

    return $rows;

}

function addReferentie($conn, $userid, $reisid, $message) {
    echo $userid, $reisid, $message;
    $sql = "INSERT INTO referentie (usersId, reisId, referentieText) VALUES (?, ?, ?);";
    echo "<>" . $sql;
    sql_execute($conn, $sql, "sss", [$userid, $reisid, $message], true);
}

function resetPwd($conn, $email, $pwd) {
    $emailExists = uidExists($conn, "", $email);

    if ($emailExists === false) {
        header("location: ../login.php?error=wrongemail");
        exit();
    }
    $sql = "UPDATE users SET usersPwd = ? WHERE usersEmail = ?;";
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    sql_execute($conn, $sql, "ss", [$hashedPwd, $email], true);
    header("location: ../login.php?error=none");
    exit();
}

function annuleren($conn, $boekingId) {
    $date = date('Y-m-d', getdate()[0]);
    $sql = "UPDATE boeking SET boekingGeannuleerd = ?, boekingDatumGeannuleerd = ? WHERE boekingId = ?;";
    sql_execute($conn, $sql, "sss", [1, $date, $boekingId], true);
    header("location: ../profile.php");
    exit();
}