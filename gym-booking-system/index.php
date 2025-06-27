<?php
require_once 'includes/functions.php';
require_once 'config/database.php';
require_once 'models/Trainer.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Get trainers for display
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
    <title>RapidFit - Gym Slot Booking System</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <!-- custom css file link  -->
    <link rel="stylesheet" href="frontend/css/index.css">

</head>

<body>

    <!-- header section starts -->
    <header class="header">
        <a href="#" class="logo"> <span>RAPID</span>FIT </a>
        <div id="menu-btn" class="fas fa-bars"></div>
        <nav class="navbar">
            <a href="#home">home</a>
            <a href="#about">about</a>
            <a href="#features">features</a>
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

    <!-- home section starts -->
    <section class="home" id="home">
        <div class="swiper home-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide slide" style="background: url(frontend/images/home-bg-2.jpg) no-repeat;">
                    <div class="content">
                        <span>be strong, be fit</span>
                        <h3>Make yourself stronger than your excuses.</h3>
                        <?php if (!isLoggedIn()): ?>
                            <a href="login.php" class="btn">get started</a>
                        <?php else: ?>
                            <a href="booking.php" class="btn">book now</a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="swiper-slide slide" style="background: url(frontend/images/home-bg-1.jpg) no-repeat;">
                    <div class="content">
                        <span>be strong, be fit</span>
                        <h3>Make yourself stronger than your excuses.</h3>
                        <?php if (!isLoggedIn()): ?>
                            <a href="login.php" class="btn">get started</a>
                        <?php else: ?>
                            <a href="booking.php" class="btn">book now</a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="swiper-slide slide" style="background: url(frontend/images/home-bg-3.jpg) no-repeat;">
                    <div class="content">
                        <span>be strong, be fit</span>
                        <h3>Make yourself stronger than your excuses.</h3>
                        <?php if (!isLoggedIn()): ?>
                            <a href="login.php" class="btn">get started</a>
                        <?php else: ?>
                            <a href="booking.php" class="btn">book now</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <!-- about section starts -->
    <section class="about" id="about">
        <div class="image">
            <img src="frontend/images/home-img-zym.png" alt="">
        </div>
        <div class="content">
            <span>about us</span>
            <h3 class="title">Every day is a chance to become better</h3>
            <p>Give your workout more variety than ever with our accessories, from warmup to cooldown. Increase your body's capacities every day, from stability to mobility, from power to speed.</p>
            <div class="box-container">
                <div class="box">
                    <h3><i class="fas fa-check"></i>body and mind</h3>
                    <p>Commercial Treadmill Series.</p>
                </div>
                <div class="box">
                    <h3><i class="fas fa-check"></i>healthy life</h3>
                    <p>Commercial Elliptical Series.</p>
                </div>
                <div class="box">
                    <h3><i class="fas fa-check"></i>strategies</h3>
                    <p>Commercial Cycling Series.</p>
                </div>
                <div class="box">
                    <h3><i class="fas fa-check"></i>workout</h3>
                    <p>Special Performance.</p>
                </div>
            </div>
            <a href="#features" class="btn">read more</a>
        </div>
    </section>

    <!-- features section starts -->
    <section class="features" id="features">
        <h1 class="heading"> <span>gym features</span> </h1>
        <div class="box-container">
            <div class="box">
                <div class="image">
                    <img src="frontend/images/trainer-3.jpg" alt="">
                </div>
                <div class="content">
                    <img src="frontend/images/icon-1.png" alt="">
                    <h3>body building</h3>
                    <p>Experience the workout with our modern equipment.</p>
                    <a href="trainers.php" class="btn">Read more</a>
                </div>
            </div>

            <div class="box second">
                <div class="image">
                    <img src="frontend/images/zym-girl.png" alt="">
                </div>
                <div class="content">
                    <img src="frontend/images/icon-2.png" alt="">
                    <h3>gym for men</h3>
                    <p>Transform your body with RapidFit's personalized training</p>
                    <a href="trainers.php" class="btn">Read more</a>
                </div>
            </div>

            <div class="box">
                <div class="image">
                    <img src="frontend/images/f-img-3.jpg" alt="">
                </div>
                <div class="content">
                    <img src="frontend/images/icon-3.png" alt="">
                    <h3>Gym for women</h3>
                    <p>Get expert guidance and achieve your goals with RapidFit</p>
                    <a href="trainers.php" class="btn">Read more</a>
                </div>
            </div>
        </div>
    </section>

    <!-- pricing section starts -->
    <section class="pricing" id="pricing">
        <div class="information">
            <span>pricing plan</span>
            <h3>affordable pricing plan for your fitness journey</h3>
            <p>RapidFit is equipped with finest trainers as the foundation and most spacious training areas for weight lifting to functional, Hygienic washroom, cafeteria, and dedicated space for dance and zumba class.</p>
            <p> <i class="fas fa-check"></i> cardio exercise </p>
            <p> <i class="fas fa-check"></i> weight lifting </p>
            <p> <i class="fas fa-check"></i> diet plans </p>
            <p> <i class="fas fa-check"></i> overall results </p>
            <a href="pricing.php" class="btn">all pricing</a>
        </div>

        <div class="plan basic">
            <h3>basic plan</h3>
            <div class="price"><span>$</span>30<span>/mo</span></div>
            <div class="list">
                <p> <i class="fas fa-check"></i> personal training </p>
                <p> <i class="fas fa-check"></i> cardio exercise </p>
                <p> <i class="fas fa-check"></i> weight lifting </p>
                <p> <i class="fas fa-check"></i> diet plans </p>
                <p> <i class="fas fa-check"></i> overall results </p>
            </div>
            <a href="login.php" class="btn">get started</a>
        </div>

        <div class="plan">
            <h3>premium plan</h3>
            <div class="price"><span>$</span>90<span>/mo</span></div>
            <div class="list">
                <p> <i class="fas fa-check"></i> personal training </p>
                <p> <i class="fas fa-check"></i> cardio exercise </p>
                <p> <i class="fas fa-check"></i> weight lifting </p>
                <p> <i class="fas fa-check"></i> diet plans </p>
                <p> <i class="fas fa-check"></i> overall results </p>
            </div>
            <a href="login.php" class="btn">get started</a>
        </div>
    </section>

    <!-- banner section starts -->
    <section class="banner">
        <span>Join us now</span>
        <h3>Get upto 50% discount</h3>
        <p>Don't just take our word for it - read what our clients have to say!</p>
        <a href="pricing.php" class="btn">Get discount</a>
    </section>

    <!-- review section starts -->
    <section class="review">
        <div class="information">
            <span>Testimonials</span>
            <h3>what our clients says</h3>
            <p>One of the best Gym's I have ever joined. Excellent space, equipment and service. Special shout out to our Personal Trainers for their unique and dynamic workouts</p>
            <a href="#" class="btn">read more</a>
        </div>

        <div class="swiper review-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide slide">
                    <p>This gym is amazing with super facility, top equipment and great environment. Good service.</p>
                    <div class="user">
                        <img src="frontend/images/pic-1.png" alt="">
                        <div class="info">
                            <h3>Vishal Singh</h3>
                            <span>designer</span>
                        </div>
                        <i class="fas fa-quote-left"></i>
                    </div>
                </div>

                <div class="swiper-slide slide">
                    <p>One of the best Gym's I have ever joined. Excellent space, equipment and service.</p>
                    <div class="user">
                        <img src="frontend/images/pic-2.png" alt="">
                        <div class="info">
                            <h3>Ayushi soni</h3>
                            <span>designer</span>
                        </div>
                        <i class="fas fa-quote-left"></i>
                    </div>
                </div>

                <div class="swiper-slide slide">
                    <p>Amazing gym great trainers well equipped gym.</p>
                    <div class="user">
                        <img src="frontend/images/pic-3.png" alt="">
                        <div class="info">
                            <h3>Aman</h3>
                            <span>designer</span>
                        </div>
                        <i class="fas fa-quote-left"></i>
                    </div>
                </div>

                <div class="swiper-slide slide">
                    <p>Our trainers are very good and RapidFit is very spacious. If any personal trainer required please contact us.</p>
                    <div class="user">
                        <img src="frontend/images/pic-4.png" alt="">
                        <div class="info">
                            <h3>Himanshu</h3>
                            <span>designer</span>
                        </div>
                        <i class="fas fa-quote-left"></i>
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
                <a class="links" href="#home">home</a>
                <a class="links" href="#about">about</a>
                <a class="links" href="#features">features</a>
                <a class="links" href="#pricing">pricing</a>
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
                <h3>Newsletter</h3>
                <p>Subscribe for latest updates ❤️</p>
                <form action="newsletter.php" method="POST">
                    <input type="email" name="email" class="email" placeholder="enter your email" required>
                    <input type="submit" value="subscribe" class="btn">
                </form>
            </div>
        </div>
    </section>

    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <script src="frontend/script/index.js"></script>

</body>

</html> 