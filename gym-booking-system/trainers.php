<?php
require_once 'includes/functions.php';
require_once 'config/database.php';
require_once 'models/Trainer.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Get trainers
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
    <title>Our Trainers - RapidFit</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="frontend/css/index.css">

</head>
<body>

    <!-- header section starts -->
    <header class="header">
        <a href="./index.php" class="logo"> <span>RAPID</span>FIT </a>
        <div id="menu-btn" class="fas fa-bars"></div>
        <nav class="navbar">
            <a href="index.php">home</a>
            <a href="index.php#about">about</a>
            <a href="index.php#features">features</a>
            <a href="pricing.php">pricing</a>
            <a href="trainers.php">trainers</a>
            <?php if (isLoggedIn()): ?>
                <a href="dashboard.php">dashboard</a>
                <a href="logout.php">logout</a>
            <?php else: ?>
                <a href="login.php">Register Now</a>
            <?php endif; ?>
        </nav>
    </header>

    <!-- trainers section starts -->
    <section class="trainers" id="trainers">
        <h1 class="heading"> <span>our trainers</span> </h1>
        
        <div class="box-container">
            <?php foreach ($trainers_data as $trainer): ?>
                <div class="box">
                    <div class="image">
                        <img src="frontend/images/<?php echo $trainer['image'] ?: 'trainer-default.jpg'; ?>" alt="<?php echo htmlspecialchars($trainer['name']); ?>">
                    </div>
                    <div class="content">
                        <h3><?php echo htmlspecialchars($trainer['name']); ?></h3>
                        <p><strong>Age:</strong> <?php echo $trainer['age']; ?> years</p>
                        <p><strong>Gender:</strong> <?php echo htmlspecialchars($trainer['gender']); ?></p>
                        <p><strong>Specialization:</strong> <?php echo htmlspecialchars($trainer['specialization']); ?></p>
                        <p><strong>Price:</strong> $<?php echo $trainer['price']; ?> per session</p>
                        <?php if (isLoggedIn()): ?>
                            <a href="booking.php?trainer_id=<?php echo $trainer['id']; ?>" class="btn">Book Session</a>
                        <?php else: ?>
                            <a href="login.php" class="btn">Login to Book</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
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

    <script src="frontend/script/index.js"></script>
</body>
</html> 