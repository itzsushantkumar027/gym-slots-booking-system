<?php
session_start();

// Authentication functions
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

function logout() {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Email functions
function sendBookingConfirmation($user_email, $booking_date, $booking_slot, $trainer_name) {
    $to = $user_email;
    $subject = "Booking Confirmation - RapidFit";
    
    $message = "
    <html>
    <head>
        <title>Booking Confirmation</title>
    </head>
    <body>
        <h2>Booking Confirmation</h2>
        <p>Your booking has been confirmed successfully!</p>
        <p><strong>Date:</strong> " . date('F j, Y', strtotime($booking_date)) . "</p>
        <p><strong>Time:</strong> " . $booking_slot . "</p>
        <p><strong>Trainer:</strong> " . $trainer_name . "</p>
        <p>Thank you for choosing RapidFit!</p>
    </body>
    </html>
    ";
    
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: RapidFit <noreply@rapidfit.com>' . "\r\n";
    
    return mail($to, $subject, $message, $headers);
}

// Validation functions
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validateDate($date) {
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

function validateTime($time) {
    $t = DateTime::createFromFormat('H:i:s', $time);
    return $t && $t->format('H:i:s') === $time;
}

// Sanitization functions
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Date and time functions
function formatDate($date) {
    return date('F j, Y', strtotime($date));
}

function formatTime($time) {
    return date('g:i A', strtotime($time));
}

function getCurrentDate() {
    return date('Y-m-d');
}

function getAvailableDates() {
    $dates = [];
    for ($i = 0; $i < 30; $i++) {
        $date = date('Y-m-d', strtotime("+$i days"));
        $dates[] = $date;
    }
    return $dates;
}

// Flash message functions
function setFlashMessage($type, $message) {
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

function getFlashMessage() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

function displayFlashMessage() {
    $flash = getFlashMessage();
    if ($flash) {
        $type = $flash['type'];
        $message = $flash['message'];
        echo "<div class='alert alert-$type'>$message</div>";
    }
}

// CSRF protection
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// File upload functions
function uploadImage($file, $target_dir = "uploads/") {
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $target_file = $target_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check if image file is actual image
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        return false;
    }
    
    // Check file size (5MB max)
    if ($file["size"] > 5000000) {
        return false;
    }
    
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        return false;
    }
    
    // Generate unique filename
    $filename = uniqid() . '.' . $imageFileType;
    $target_file = $target_dir . $filename;
    
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $filename;
    }
    
    return false;
}

// Pagination functions
function getPagination($total_records, $records_per_page, $current_page) {
    $total_pages = ceil($total_records / $records_per_page);
    
    return [
        'total_pages' => $total_pages,
        'current_page' => $current_page,
        'has_previous' => $current_page > 1,
        'has_next' => $current_page < $total_pages,
        'previous_page' => $current_page - 1,
        'next_page' => $current_page + 1
    ];
}

// Response functions
function sendJSONResponse($data, $status_code = 200) {
    http_response_code($status_code);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit();
}

function sendErrorResponse($message, $status_code = 400) {
    sendJSONResponse(['error' => $message], $status_code);
}

function sendSuccessResponse($message, $data = null) {
    $response = ['success' => $message];
    if ($data !== null) {
        $response['data'] = $data;
    }
    sendJSONResponse($response);
}

// Utility functions
function redirect($url) {
    header("Location: $url");
    exit();
}

function back() {
    if (isset($_SERVER['HTTP_REFERER'])) {
        redirect($_SERVER['HTTP_REFERER']);
    } else {
        redirect('index.php');
    }
}

function getBaseURL() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $path = dirname($_SERVER['PHP_SELF']);
    return "$protocol://$host$path";
}

// Debug functions
function debug($data) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

function logError($message, $error = null) {
    $log_file = "logs/error.log";
    $log_dir = dirname($log_file);
    
    if (!file_exists($log_dir)) {
        mkdir($log_dir, 0777, true);
    }
    
    $timestamp = date('Y-m-d H:i:s');
    $log_message = "[$timestamp] $message";
    
    if ($error) {
        $log_message .= " - Error: " . $error->getMessage();
    }
    
    $log_message .= "\n";
    
    file_put_contents($log_file, $log_message, FILE_APPEND | LOCK_EX);
}
?> 