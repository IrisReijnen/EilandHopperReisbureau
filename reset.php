<?php
    include_once 'header.php';
    require_once 'includes/functions.inc.php';
?>

<section class="reset-form">
    <h2>Reset password</h2>
    <form action="includes/reset.inc.php" method="post">
        <input type="text" name="email" placeholder="Email...">
        <input type="password" name="pwd" placeholder="Password...">
        <input type="password" name="pwdrepeat" placeholder="Repeat password...">
        <button type="submit" name="submit">Reset password</button>
    </form>

    <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "emptyinput") {
                echo "<p>Fill in all the fields!</p>";
            }
            if ($_GET["error"] == "invalidemail") {
                echo "<p>Not a proper email address.</p>";
                exit();
            }
            if ($_GET["error"] == "wrongemail") {
                echo "<p>Wrong email address.</p>";
                exit();
            }
            else if ($_GET["error"] == "pwdsdontmatch") {
                echo "<p>Passwords don't match.</p>";
            }
            else if ($_GET["error"] == "stmtfailed") {
                echo "<p>Something went wrong, try again!</p>";
            }
            else if ($_GET["error"] == "none") {
                echo "<p>You have reset your password!</p>";
            }
        }
    ?>
</section>



<?php
    include_once 'footer.php';
?>