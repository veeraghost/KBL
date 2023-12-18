<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['fname'];
    $email = $_POST['email'];
    $adrress = $_POST['adr'];
    $payment = $_POST['utr'];

    $file_attached = false;
    if (isset($_FILES['file_name']) && $_FILES['file_name']['error'] === UPLOAD_ERR_OK) {
        $file_attached = true;
        $file_name = $_FILES['file_name']['name'];
        $file_tmp = $_FILES['file_name']['tmp_name'];
    }

    $to = "contact@keralalotterybumper.com"; // Replace with the recipient email address
    $subject = "Payment reciept $name";
    $body = "Name: $name\nEmail: $email\nUTR: $payment\nMessage: $message";

    // To send HTML mail, the Content-type header must be set
    

    if ($file_attached) {
        $boundary = md5(rand());
        $headers .= "\r\nMIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"" . $boundary . "\"\r\n\r\n";
        $headers = "From: $email\r\n";
        $headers .= "Content-type: text/plain; charset=UTF-8\r\n";

        $message .= "\r\n\r\n--" . $boundary . "\r\n";
        $message .= "Content-Type: application/octet-stream; name=\"" . $file_name . "\"\r\n";
        $message .= "Content-Transfer-Encoding: base64\r\n";
        $message .= "Content-Disposition: attachment; filename=\"" . $file_name . "\"\r\n\r\n";
        $message .= chunk_split(base64_encode(file_get_contents($file_tmp))) . "\r\n";
        $message .= "--" . $boundary . "--";
    }
    
    // Send email
    if (mail($to, $subject, $body, $headers)) {

        header("Location: thankyou.html"); // Replace with your thank you page
        exit;

    } else {
        echo "Failed to send email.";
    }

    // Redirect after sending email
    
}
?>