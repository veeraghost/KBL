<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form field values
    $name = $_POST['fname'];
    $email = $_POST['email'];
    $adrress = $_POST['adr'];
    $payment = $_POST['utr'];


    // File upload handling
    $file_attached = isset($_FILES['filename']) ? $_FILES['filename'] : null;

    // Check if a file is uploaded
    if ($file_attached && $file_attached['error'] == UPLOAD_ERR_OK) {
        $file_name = $file_attached['name'];
        $file_temp = $file_attached['tmp_name'];

        // Read the file content
        $file_content = file_get_contents($file_temp);

        // Base64 encode the file content
        $file_encoded = chunk_split(base64_encode($file_content));

        // Set up headers for attachment
        $attachment_headers = "MIME-Version: 1.0\r\n";
        $attachment_headers .= "Content-Type: application/octet-stream\r\n";
        $attachment_headers .= "Content-Disposition: attachment; filename=\"$file_name\"\r\n";
        $attachment_headers .= "Content-Transfer-Encoding: base64\r\n";

        // Construct the email body
        $email_body = "Subject: Payment Reciept $name\n\n";
        $email_body .= "Message: $message\n";

        // Attach the file content
        $email_body .= "--boundary\r\n";
        $email_body .= "Content-Type: application/octet-stream; name=\"$file_name\"\r\n";
        $email_body .= "Content-Disposition: attachment; filename=\"$file_name\"\r\n";
        $email_body .= "Content-Transfer-Encoding: base64\r\n";
        $email_body .= "\n$file_encoded\n";

        // Send the email
        $to = "contact@keralalotterybumper.com"; // Replace with the recipient's email address
        $headers = "From: $email\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"boundary\"\r\n";

        if (mail($to, $subject, $email_body, $headers)) {
            echo "Email with attachment sent successfully!";
        } else {
            echo "Failed to send email.";
        }
    } else {
        echo "No file attached or error in file upload.";
    }
}
?>
