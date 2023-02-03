
<?php

if (isset($_POST["submit"])) {
    
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdrepeat"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputReset($email, $pwd, $pwdRepeat) !== false) {
        header("location: ../reset.php?error=emptyinput");
        exit();
    }
    if (pwdMatch($pwd, $pwdRepeat) !== false) {
        header("location: ../reset.php?error=pwdsdontmatch");
        exit();
    }
    if (!uidExists($conn, "", $email) !== false) {
        header("location: ../reset.php?error=wrongemail");
        exit();
    }

    resetPwd($conn, $email, $pwd);

}
else {
    header("location: ../reset.php");
    exit();
}