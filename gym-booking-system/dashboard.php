<?php
require_once 'includes/functions.php';
require_once 'config/database.php';
require_once 'models/User.php';
require_once 'models/Booking.php';
require_once 'models/Trainer.php';

// Require login
requireLogin();

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Get user data
$user = new User($db);
$user_data = $user->getById($_SESSION['user_id']);

// Get booking data
$booking = new Booking($db);
$user_bookings = $booking->getByUserId($_SESSION['user_id']);
$upcoming_bookings = $booking->getUpcomingBookings($_SESSION['user_id']);
$booking_stats = $booking->getStatistics($_SESSION['user_id']);

// Get trainers for quick booking
$trainer = new Trainer($db);
$trainers = $trainer->getAll();
$trainers_data = $trainers->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - RapidFit</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="frontend/css/dashboard.css">

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

    <!-- dashboard section starts -->
    <section class="dashboard">
        <div class="dashboard-container">
            
            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Total Bookings</h3>
                        <p class="stat-number"><?php echo $booking_stats['total_bookings']; ?></p>
                        <span class="stat-change positive">+<?php echo $booking_stats['upcoming_bookings']; ?> upcoming</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Confirmed Bookings</h3>
                        <p class="stat-number"><?php echo $booking_stats['confirmed_bookings']; ?></p>
                        <span class="stat-change positive">Active sessions</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-dumbbell"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Pending Bookings</h3>
                        <p class="stat-number"><?php echo $booking_stats['pending_bookings']; ?></p>
                        <span class="stat-change positive">Awaiting confirmation</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Upcoming Sessions</h3>
                        <p class="stat-number"><?php echo $booking_stats['upcoming_bookings']; ?></p>
                        <span class="stat-change positive">Next 30 days</span>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="main-grid">
                
                <!-- Upcoming Bookings -->
                <div class="content-card">
                    <div class="card-header">
                        <h2><i class="fas fa-calendar-alt"></i> Upcoming Bookings</h2>
                        <a href="./booking.php" class="btn-primary">Book New</a>
                    </div>
                    <div class="bookings-list">
                        <?php if (empty($upcoming_bookings)): ?>
                            <div class="no-bookings">
                                <p>No upcoming bookings. <a href="booking.php">Book your first session!</a></p>
                            </div>
                        <?php else: ?>
                            <?php foreach (array_slice($upcoming_bookings, 0, 3) as $booking): ?>
                                <div class="booking-item">
                                    <div class="booking-date">
                                        <span class="day"><?php echo date('d', strtotime($booking['booking_date'])); ?></span>
                                        <span class="month"><?php echo date('M', strtotime($booking['booking_date'])); ?></span>
                                    </div>
                                    <div class="booking-details">
                                        <h4><?php echo htmlspecialchars($booking['trainer_name']); ?></h4>
                                        <p><i class="fas fa-clock"></i> <?php echo formatTime($booking['booking_slot']); ?></p>
                                        <p><i class="fas fa-user"></i> Trainer: <?php echo htmlspecialchars($booking['trainer_name']); ?></p>
                                    </div>
                                    <div class="booking-status <?php echo $booking['status']; ?>">
                                        <span><?php echo ucfirst($booking['status']); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="content-card">
                    <div class="card-header">
                        <h2><i class="fas fa-bolt"></i> Quick Actions</h2>
                    </div>
                    <div class="quick-actions">
                        <a href="./booking.php" class="action-btn">
                            <i class="fas fa-plus"></i>
                            <span>Book Session</span>
                        </a>
                        <a href="./trainers.php" class="action-btn">
                            <i class="fas fa-users"></i>
                            <span>View Trainers</span>
                        </a>
                        <a href="./pricing.php" class="action-btn">
                            <i class="fas fa-credit-card"></i>
                            <span>Membership</span>
                        </a>
                        <a href="./my-bookings.php" class="action-btn">
                            <i class="fas fa-list"></i>
                            <span>All Bookings</span>
                        </a>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="content-card">
                    <div class="card-header">
                        <h2><i class="fas fa-history"></i> Recent Activity</h2>
                    </div>
                    <div class="activity-list">
                        <?php 
                        $recent_bookings = array_slice($user_bookings, 0, 3);
                        if (empty($recent_bookings)): ?>
                            <div class="no-activity">
                                <p>No recent activity. Start your fitness journey today!</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($recent_bookings as $booking): ?>
                                <div class="activity-item">
                                    <div class="activity-icon <?php echo $booking['status']; ?>">
                                        <i class="fas fa-<?php echo $booking['status'] === 'confirmed' ? 'check' : ($booking['status'] === 'pending' ? 'clock' : 'calendar'); ?>"></i>
                                    </div>
                                    <div class="activity-content">
                                        <h4><?php echo ucfirst($booking['status']); ?> Booking</h4>
                                        <p>Session with <?php echo htmlspecialchars($booking['trainer_name']); ?> on <?php echo formatDate($booking['booking_date']); ?></p>
                                        <span class="activity-time"><?php echo formatTime($booking['booking_slot']); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Progress Chart -->
                <div class="content-card">
                    <div class="card-header">
                        <h2><i class="fas fa-chart-line"></i> Monthly Progress</h2>
                    </div>
                    <div class="progress-chart">
                        <div class="chart-container">
                            <canvas id="progressChart" width="400" height="200"></canvas>
                        </div>
                        <div class="chart-legend">
                            <div class="legend-item">
                                <span class="legend-color bookings"></span>
                                <span>Bookings</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-color sessions"></span>
                                <span>Completed Sessions</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="frontend/script/dashboard.js"></script>
</body>

</html> 