<head>
  <script src=
    "https://smtpjs.com/v3/smtp.js">
  </script>

  <script type="text/javascript">
    // From https://www.geeksforgeeks.org/how-to-send-an-email-from-javascript/
    function sendEmail(form) {
        // For now claim email sent already here
        let confirmation_text = "Thank you for reaching out to us, we will get back to you shortly!";// + str(form.email.value) + "!"
        alert(confirmation_text)
        //alert(form.email.value);
        Email.send({
        Host: "smtp.gmail.com",
        Username: "sender@email_address.com",
        Password: "Enter your password",
        To: 'reisbureau2023@gmail.com',
        From: form.email.value,
        Subject: "Sending Email using javascript",
        Body: form.message.value,
        })
            .then(function (message) {
                alert(confirmation_text)
            });
    }
  </script>
</head>


<?php
    include_once 'header.php';
    require_once 'includes/dbh.inc.php';
?>

<div class="container">
<h1>Contact</h1>
<form method="post" name="contact" onsubmit="return sendEmail(this)">
    Your Name:
    <input type="text" name="name">

    Email Address:
    <?php
    if (isset($_SESSION["useremail"])) {
        $email = $_SESSION["useremail"];
        echo "<input type='text' value=$email name='email'>";
    } else {
        echo "<input type='text' name='email'>";
    }
    ?>
    Message:
    <textarea name="message"></textarea>
    <input id="send" type="submit" value="Submit">
</form>
</div>

<?php
    include_once 'footer.php';
?>