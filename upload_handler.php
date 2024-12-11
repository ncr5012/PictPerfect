<?php
// Update these with your details
$to_email = "ncr5012@gmail.com"; // Replace with your email address
$subject = "New Loan Estimate Uploaded";
$message = "A new file has been uploaded.";

// Check if a file was uploaded and no error occurred
if(isset($_FILES['uploaded_file']) && $_FILES['uploaded_file']['error'] == 0) {
    
    $file_tmp_name = $_FILES['uploaded_file']['tmp_name'];
    $file_name = $_FILES['uploaded_file']['name'];
    $file_size = $_FILES['uploaded_file']['size'];
    $file_type = $_FILES['uploaded_file']['type'];

    // Read the file content
    $file_content = chunk_split(base64_encode(file_get_contents($file_tmp_name)));

    // Create a unique boundary to separate parts of the email
    $boundary = md5(time());

    // Set headers for sending email with attachment
    $headers = "From: noreply@yloan-tiger.com\r\n"; 
    $headers .= "MIME-Version: 1.0\r\n"; 
    $headers .= "Content-Type: multipart/mixed; boundary=\"".$boundary."\"\r\n"; 

    // Plain text part
    $body = "--$boundary\r\n";
    $body .= "Content-Type: text/plain; charset=\"UTF-8\"\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $body .= $message."\r\n";

    // Attachment part
    $body .= "--$boundary\r\n";
    $body .= "Content-Type: ".$file_type."; name=\"".$file_name."\"\r\n"; 
    $body .= "Content-Transfer-Encoding: base64\r\n";
    $body .= "Content-Disposition: attachment; filename=\"".$file_name."\"\r\n\r\n"; 
    $body .= $file_content."\r\n"; 
    $body .= "--$boundary--";

    // Send the email
    if(mail($to_email, $subject, $body, $headers)) {
        echo "File uploaded and email sent successfully!";
    } else {
        echo "Failed to send the email.";
    }

} else {
    echo "No file uploaded or an error occurred.";
}
