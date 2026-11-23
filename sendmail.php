<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
// Include PHPMailer library (no composer)
require 'C:\xampp\htdocs\CarbonBlueFinal2\phpmailer\phpmailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\CarbonBlueFinal2\phpmailer\phpmailer\src\SMTP.php';
require 'C:\xampp\htdocs\CarbonBlueFinal2\phpmailer\phpmailer\src\Exception.php';
 
// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = $_POST['name'];
    $email   = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
 
    $mail = new PHPMailer(true);
 
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'carbonblue676@gmail.com';          // your Gmail
        $mail->Password   = 'dmkn ervy amce bkyv';            // your Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
 
        // Recipients
        $mail->setFrom($email, $name);                      // From the user
        $mail->addAddress('carbonblue676@gmail.com');         // To Carbon Blue
 
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "
<h3>New Feedback Received</h3>
<p><strong>Name:</strong> $name</p>
<p><strong>Email:</strong> $email</p>
<p><strong>Message:</strong><br>$message</p>
        ";
 
        $mail->send();
        echo "<script>alert('Thank you! Your message has been sent.'); window.location.href='contact.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Sorry, mail failed: {$mail->ErrorInfo}'); window.location.href='contact.php';</script>";
    }
}
?>