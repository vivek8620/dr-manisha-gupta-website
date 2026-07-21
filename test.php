<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// use PHPMailer\src\Exception;

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

$log = "";

$mail = new PHPMailer(true);

try {

    // Capture SMTP Debug
    $mail->SMTPDebug = 3;
    $mail->Debugoutput = function ($str, $level) use (&$log) {
        $log .= htmlspecialchars($str) . "\n";
    };

    // SMTP Settings
    $mail->isSMTP();
    $mail->Host = 'smtp.mail.yahoo.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'manisha_guptaus@yahoo.com';
    $mail->Password = 'boyaxpytzfihmgdy';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Email
    $mail->setFrom('manisha_guptaus@yahoo.com', 'SMTP Test');
    $mail->addAddress('manisha_guptaus@yahoo.com');

    $mail->Subject = 'Re: Message from Dr. Manisha Gupta Website';
    $mail->Body = 'This is a test email sent from the Dr. Manisha Gupta Website.';

    $mail->send();

    $status = "<span style='color:green;font-weight:bold'>✅ Email Sent Successfully</span>";

} catch (Exception $e) {

    $status = "<span style='color:red;font-weight:bold'>❌ Failed : "
        . htmlspecialchars($mail->ErrorInfo) .
        "</span>";

    $log .= "\n\nException:\n" . htmlspecialchars($e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>SMTP Test</title>

<style>
body{
    font-family:Arial;
    background:#f4f4f4;
    padding:30px;
}
.container{
    max-width:1000px;
    margin:auto;
    background:#fff;
    padding:20px;
    border-radius:8px;
    box-shadow:0 0 10px rgba(0,0,0,.15);
}
pre{
    background:#111;
    color:#00ff00;
    padding:15px;
    border-radius:5px;
    overflow:auto;
    height:500px;
    white-space:pre-wrap;
    font-size:13px;
}
</style>

</head>

<body>

<div class="container">

<h2>SMTP Test</h2>

<p><?php echo $status; ?></p>

<h3>SMTP Log</h3>

<pre><?php echo $log; ?></pre>

</div>

</body>
</html>