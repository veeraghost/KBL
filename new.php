<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to_email = "contact@keralalotterybumper.com";
    $email = $_POST['email'];
    $subject = "New Email via Form";
    $message = $_POST['message'];
    
    // File upload handling
    $file_attached = false;
    if ($_FILES['attach']['error'] == UPLOAD_ERR_OK) {
        $file_attached = true;
        $file_name = $_FILES['attach']['name'];
        $file_tmp = $_FILES['attach']['tmp_name'];
        $file_type = $_FILES['attach']['type'];
        $file_size = $_FILES['attach']['size'];
        
        // Temporary file path
        $file = fopen($file_tmp, 'rb');
        $data = fread($file, filesize($file_tmp));
        fclose($file);
        $data = chunk_split(base64_encode($data));
        
        // Email headers
        $boundary = md5(time());
        $headers = "From: $email\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"" . $boundary . "\"\r\n\r\n";
        
        // Email body
        $body = "--" . $boundary . "\r\n";
        $body .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= $message . "\r\n\r\n";
        
        $body .= "--" . $boundary . "\r\n";
        $body .= "Content-Type: " . $file_type . "; name=\"" . $file_name . "\"\r\n";
        $body .= "Content-Disposition: attachment; filename=\"" . $file_name . "\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n";
        $body .= "X-Attachment-Id: " . rand(1000, 99999) . "\r\n\r\n";
        $body .= $data . "\r\n";
        $body .= "--" . $boundary . "--";
        
        // Sending email
        if (mail($to_email, $subject, $body, $headers)) {
            echo "Email sent successfully.";
        } else {
            echo "Email sending failed.";
        }
    } else {
        echo "Error uploading file.";
    }
} else {
    echo "Invalid request.";
}
?>