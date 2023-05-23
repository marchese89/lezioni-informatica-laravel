<?php
// Include required PHPMailer files
require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';
// Define name spaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Create instance of PHPMailer
$mail = new PHPMailer();
// Set mailer to use smtp
$mail->isSMTP();
// Define smtp host
$mail->Host = "smtps.aruba.it";
// Enable smtp authentication
$mail->SMTPAuth = true;
// Set smtp encryption type (ssl/tls)
$mail->SMTPSecure = "ssl";
// Port to connect smtp
$mail->Port = "465";
// Set gmail username
$mail->Username = "info@lezioni-marchese.it";
// Set gmail password
$mail->Password = "3DWjnkVW#tkez5NS";
// Email subject
$mail->Subject = "Test email using PHPMailer";
// Set sender email
$mail->setFrom('info@lezioni-marchese.it');
// Enable HTML
$mail->isHTML(true);
// Attachment
$mail->addAttachment('img/attachment.png');
// Email body
$mail->Body = "<h1>Ciao Mondo</h1></br><p>This is html paragraph</p>";
// Add recipient
$mail->addAddress('marchese.antoniogiovanni@gmail.com');
// Finally send email
if ($mail->send()) {
    echo "Email Sent..!";
} else {
    echo "Message could not be sent. Mailer Error: " . $mail->ErrorInfo;
}
// Closing smtp connection
$mail->smtpClose();
