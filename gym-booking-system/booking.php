<?php
require_once 'includes/functions.php';
require_once 'config/database.php';
require_once 'models/User.php';
require_once 'models/Trainer.php';
require_once 'models/Booking.php';

// Require login
requireLogin();

// Get database connection
$database = new Database();
$db = $database->getConnection();

$error = '';
$success = '';

// Handle booking submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trainer_id = sanitizeInput($_POST['trainer_id']);
    $booking_date = sanitizeInput($_POST['booking_date']);
    $booking_slot = sanitizeInput($_POST['booking_slot']);
    
    // Validation
    if (empty($trainer_id) || empty($booking_date) || empty($booking_slot)) {
        $error = 'All fields are required';
    } elseif (!validateDate($booking_date)) {
        $error = 'Please select a valid date';
    } elseif (strtotime($booking_date) < strtotime('today')) {
        $error = 'Cannot book for past dates';
    } else {
        $booking = new Booking($db);
        
        // Check if slot is available
        if ($booking->isSlotAvailable($trainer_id, $booking_date, $booking_slot)) {
            // Create booking
            $booking->user_id = $_SESSION['user_id'];
            $booking->trainer_id = $trainer_id;
            $booking->user_email = $_SESSION['user_email'];
            $booking->booking_date = $booking_date;
            $booking->booking_slot = $booking_slot;
            $booking->status = 'pending';
            
            if ($booking->create()) {
                // Get trainer name for email
                $trainer = new Trainer($db);
                $trainer_data = $trainer->getById($trainer_id);
                
                // Send confirmation email
                if (sendBookingConfirmation($_SESSION['user_email'], $booking_date, $booking_slot, $trainer_data['name'])) {
                    $success = 'Booking created successfully! Confirmation email sent.';
                } else {
                    $success = 'Booking created successfully!';
                }
                
                setFlashMessage('success', $success);
                redirect('dashboard.php');
            } else {
                $error = 'Failed to create booking. Please try again.';
            }
        } else {
            $error = 'This time slot is not available. Please select another time.';
        }
    }
}

// Get trainers
$trainer = new Trainer($db);
$trainers = $trainer->getAll();
$trainers_data = $trainers->fetchAll(PDO::FETCH_ASSOC);

// Get available dates
$available_dates = getAvailableDates();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Session - RapidFit</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="frontend/css/appointment.css">

</head>
<body>

    <!-- header section starts -->
    <header class="header">
        <a href="./index.php" class="logo"> <span>RAPID</span>FIT </a>
        <div class="user-info">
            <span class="user-name">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
            <a href="./logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </header>

    <!-- booking section starts -->
    <section class="input-part">
        <div id="main_cont">
            <div id="navbar">
                <a href="dashboard.php" id="all_appointment">Back to Dashboard</a>
            </div>

            <h2>Book Your Training Session</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST" id="main_body">
                <div>
                    <label for="trainer_id">Select Trainer:</label>
                    <select name="trainer_id" id="trainer_id" required>
                        <option value="">Choose a trainer</option>
                        <?php foreach ($trainers_data as $trainer): ?>
                            <option value="<?php echo $trainer['id']; ?>">
                                <?php echo htmlspecialchars($trainer['name']); ?> - 
                                <?php echo htmlspecialchars($trainer['specialization']); ?> 
                                ($<?php echo $trainer['price']; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="booking_date">Select Date:</label>
                    <input type="date" name="booking_date" id="booking_date" min="<?php echo date('Y-m-d'); ?>" required>
                </div>

                <div>
                    <label for="booking_slot">Select Time Slot:</label>
                    <select name="booking_slot" id="booking_slot" required>
                        <option value="">Choose a time slot</option>
                        <option value="06:00:00">6:00 AM - 8:00 AM</option>
                        <option value="08:00:00">8:00 AM - 10:00 AM</option>
                        <option value="16:00:00">4:00 PM - 6:00 PM</option>
                        <option value="18:00:00">6:00 PM - 8:00 PM</option>
                    </select>
                </div>

                <button type="submit" id="book_appointment">Book Appointment</button>
            </form>
        </div>
    </section>

    <!-- footer section starts -->
    <section class="footer">
        <div class="box-container">
            <div class="box">
                <h3>quick links</h3>
                <a class="links" href="index.php">home</a>
                <a class="links" href="index.php#about">about</a>
                <a class="links" href="index.php#features">features</a>
                <a class="links" href="pricing.php">pricing</a>
                <a class="links" href="trainers.php">trainers</a>
                <a class="links" href="booking.php">appointment</a>
            </div>

            <div class="box">
                <h3>opening hours</h3>
                <p> monday : <i> 7:00am - 10:30pm </i> </p>
                <p> tuesday : <i> 7:00am - 10:30pm </i> </p>
                <p> wednesday : <i> 7:00am - 10:30pm </i> </p>
                <p> friday : <i> 7:00am - 10:30pm </i> </p>
                <p> saturday : <i> 7:00am - 10:30pm </i> </p>
                <p> sunday : <i> closed </i> </p>
            </div>

            <div class="box">
                <h3>contact info</h3>
                <p> <i class="fas fa-phone"></i> +123-456-7890 </p>
                <p> <i class="fas fa-phone"></i> +111-222-3333 </p>
                <p> <i class="fas fa-envelope"></i> rapidfit@gmail.com </p>
                <p> <i class="fas fa-map"></i> Noida, india - 400104 </p>
                <div class="share">
                    <a href="#" class="fab fa-facebook-f"></a>
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-linkedin"></a>
                    <a href="#" class="fab fa-pinterest"></a>
                </div>
            </div>

            <div class="box">
                <h3>newsletter</h3>
                <p>subscribe for latest updates</p>
                <form action="newsletter.php" method="POST">
                    <input type="email" name="email" class="email" placeholder="enter your email" required>
                    <input type="submit" value="subscribe" class="btn">
                </form>
            </div>
        </div>
    </section>

    <script>
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

        // Add form validation
        document.getElementById('main_body').addEventListener('submit', function(e) {
            const trainer = document.getElementById('trainer_id').value;
            const date = document.getElementById('booking_date').value;
            const slot = document.getElementById('booking_slot').value;
            
            if (!trainer || !date || !slot) {
                e.preventDefault();
                alert('Please fill in all fields');
                return false;
            }
            
            const selectedDate = new Date(date);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (selectedDate < today) {
                e.preventDefault();
                alert('Cannot book for past dates');
                return false;
            }
        });
    </script>
</body>
</html> 