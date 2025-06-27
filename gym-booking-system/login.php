<?php
require_once 'includes/functions.php';
require_once 'config/database.php';
require_once 'models/User.php';

// If user is already logged in, redirect to dashboard
if (isLoggedIn()) {
    redirect('dashboard.php');
}

$error = '';
$success = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $user = new User($db);

    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'signup') {
            // Handle signup
            $name = sanitizeInput($_POST['name']);
            $email = sanitizeInput($_POST['email']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // Validation
            if (empty($name) || empty($email) || empty($password)) {
                $error = 'All fields are required';
            } elseif (!validateEmail($email)) {
                $error = 'Please enter a valid email address';
            } elseif (strlen($password) < 6) {
                $error = 'Password must be at least 6 characters long';
            } elseif ($password !== $confirm_password) {
                $error = 'Passwords do not match';
            } else {
                // Check if email already exists
                $user->email = $email;
                if ($user->emailExists()) {
                    $error = 'Email already registered';
                } else {
                    // Create new user
                    $user->name = $name;
                    $user->password = $password;
                    
                    if ($user->create()) {
                        $success = 'Registration successful! Please login.';
                    } else {
                        $error = 'Registration failed. Please try again.';
                    }
                }
            }
        } elseif ($_POST['action'] === 'login') {
            // Handle login
            $email = sanitizeInput($_POST['login_email']);
            $password = $_POST['login_password'];

            if (empty($email) || empty($password)) {
                $error = 'Email and password are required';
            } else {
                $user->email = $email;
                if ($user->emailExists()) {
                    if (password_verify($password, $user->password)) {
                        // Login successful
                        $_SESSION['user_id'] = $user->id;
                        $_SESSION['user_name'] = $user->name;
                        $_SESSION['user_email'] = $user->email;
                        
                        setFlashMessage('success', 'Login successful!');
                        redirect('dashboard.php');
                    } else {
                        $error = 'Invalid password';
                    }
                } else {
                    $error = 'Email not found';
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Register - RapidFit</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="frontend/css/Login.css">

</head>
<body>
    <div class="container">
        <!-- Login Form -->
        <div class="login-wrap active">
            <div class="title">
                <h1>Login</h1>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST">
                <input type="hidden" name="action" value="login">
                
                <div class="input-area">
                    <input type="email" name="login_email" id="login_email" required>
                    <label for="login_email">Email</label>
                </div>

                <div class="input-area">
                    <input type="password" name="login_password" id="login_password" required>
                    <label for="login_password">Password</label>
                </div>

                <div class="forgot-pass">
                    <a href="forgot-password.php">Forgot Password?</a>
                </div>

                <div class="button-area">
                    <button type="submit">Login</button>
                </div>
            </form>

            <div class="form-toggle-area">
                <p>Don't have an account? <span onclick="toggleForm()">Sign Up</span></p>
            </div>
        </div>

        <!-- Signup Form -->
        <div class="signup-wrap">
            <div class="title">
                <h1>Sign Up</h1>
            </div>

            <form method="POST">
                <input type="hidden" name="action" value="signup">
                
                <div class="input-area">
                    <input type="text" name="name" id="name" required>
                    <label for="name">Full Name</label>
                </div>

                <div class="input-area">
                    <input type="email" name="email" id="email" required>
                    <label for="email">Email</label>
                </div>

                <div class="input-area">
                    <input type="password" name="password" id="password" required>
                    <label for="password">Password</label>
                </div>

                <div class="input-area">
                    <input type="password" name="confirm_password" id="confirm_password" required>
                    <label for="confirm_password">Confirm Password</label>
                </div>

                <div class="button-area">
                    <button type="submit">Sign Up</button>
                </div>
            </form>

            <div class="form-toggle-area">
                <p>Already have an account? <span onclick="toggleForm()">Login</span></p>
            </div>
        </div>
    </div>

    <script>
        function toggleForm() {
            const loginWrap = document.querySelector('.login-wrap');
            const signupWrap = document.querySelector('.signup-wrap');
            
            loginWrap.classList.toggle('active');
            signupWrap.classList.toggle('active');
        }

        // Add some custom styles for alerts
        const style = document.createElement('style');
        style.textContent = `
            .alert {
                padding: 1rem 2rem;
                margin: 1rem 0;
                border-radius: 1rem;
                font-size: 1.4rem;
                text-align: center;
            }
            
            .alert-error {
                background: rgba(255, 71, 87, 0.1);
                border: 1px solid rgba(255, 71, 87, 0.3);
                color: #ff4757;
            }
            
            .alert-success {
                background: rgba(0, 255, 136, 0.1);
                border: 1px solid rgba(0, 255, 136, 0.3);
                color: #00ff88;
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html> 