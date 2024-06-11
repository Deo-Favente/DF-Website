<?php
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get POST data
    $name = isset($_POST['name']) ? strip_tags(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $message = isset($_POST['message']) ? strip_tags(trim($_POST['message'])) : '';

    // Validate form fields
    if (empty($name)) {
        $errors[] = 'Veuillez renseigner un nom';
    }

    if (empty($email)) {
        $errors[] = 'Veuillez renseigner un email';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && $email != "???") {
        $errors[] = 'Veuillez renseigner un email valide';
    }

    if (empty($message)) {
        $errors[] = 'Veuillez renseigner un message';
    }

    // If no errors, send email
    if (empty($errors)) {

        if ($name == "???" && $email == "???" && $message == "???") {
            header('Location: https://deo-favente.fr/sorsdematete');
            exit;
        }

        // Recipient email address (replace with your own)
        $recipient = "deofavente.dev@gmail.com";

        // Subject
        $subject = "Nouveau message de $name";

        // Email headers
        $headers = "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Email body
        $email_body = "Nom: $name\n";
        $email_body .= "Email: $email\n\n";
        $email_body .= "Message:\n$message\n";

        // Send email
        if (mail($recipient, $subject, $email_body, $headers)) {
            // Email sent, redirect to home page
            header("Location: /");
        } else {
            echo "Votre message n'a pas pu être envoyé, veuillez réessayer plus tard.";
        }
    } else {
        // Display errors
        echo "Les erreurs suivantes se sont produites:<br>";
        foreach ($errors as $error) {
            echo "- $error<br>";
        }
    }
} else {
    // Not a POST request, display a 403 forbidden error
    header("HTTP/1.1 403 Forbidden");
    echo "403 Forbidden";
}
?>
