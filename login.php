<head>
  <script src="https://smtpjs.com/v3/smtp.js"></script>
  <script src="includes/js/resetlink.js"></script>
</head>

<?php
    include_once 'header.php';
?>

<div class="container">
<section class="signup-form">
    <h2>Login</h2>
    <form action="includes/login.inc.php" method="post">
        <input type="text" name="uid" placeholder="Username/Email...">
        <input type="password" name="pwd" placeholder="Password...">
        <button type="submit" name="submit">Login</button>
    </form>
    <br>
    <h4>Reset password</h4>
    <form method="post" name="contact" onsubmit="return sendEmail(this)">
        Email Address:
        <input type='text' name='email'>
        <button type="submit" name="submit">Reset password</button>
    </form>

    <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "emptyinput") {
                echo "<p>Fill in all the fields!</p>";
            }
            else if ($_GET["error"] == "wronglogin") {
                echo "<p>Incorrect login information.</p>";
            }
        }
    ?>
</section>
</div>

<?php
    include_once 'footer.php';
?>