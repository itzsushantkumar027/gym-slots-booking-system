<?php
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email']);
    
    if (validateEmail($email)) {
        // In a real application, you would save this to a database
        // For now, we'll just redirect with a success message
        setFlashMessage('success', 'Thank you for subscribing to our newsletter!');
    } else {
        setFlashMessage('error', 'Please enter a valid email address.');
    }
}

// Redirect back to the previous page
back();
?> 