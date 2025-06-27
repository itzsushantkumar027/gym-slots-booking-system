# RapidFit - Gym Slot Booking System (PHP Version)

A modern, responsive gym slot booking system built with PHP, MySQL, and modern web technologies. This system allows users to register, login, book training sessions with trainers, and manage their fitness journey.

## 🚀 Features

### User Features
- **User Registration & Authentication**: Secure user registration and login system
- **Trainer Booking**: Book sessions with available trainers
- **Dashboard**: View booking statistics and upcoming sessions
- **Booking Management**: View, cancel, and manage bookings
- **Responsive Design**: Works perfectly on all devices

### Admin Features
- **Trainer Management**: Add, edit, and manage trainers
- **Booking Overview**: View all bookings and manage them
- **User Management**: View and manage user accounts
- **Statistics**: View booking statistics and reports

### Technical Features
- **Modern UI/UX**: Beautiful, responsive design with animations
- **Security**: Password hashing, input validation, and CSRF protection
- **Email Notifications**: Booking confirmation emails
- **Database**: MySQL database with proper relationships
- **Responsive**: Mobile-first design approach

## 🛠️ Technology Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript
- **Styling**: Custom CSS with modern design
- **Icons**: Font Awesome
- **Charts**: Chart.js
- **Server**: XAMPP/Apache

## 📋 Prerequisites

Before running this application, make sure you have:

- **XAMPP** installed and running
- **PHP 7.4** or higher
- **MySQL 5.7** or higher
- **Apache** web server
- **Modern web browser**

## 🚀 Installation & Setup

### Step 1: Clone/Download the Project

1. Download or clone this repository
2. Extract the files to your XAMPP's `htdocs` folder:
   ```
   C:\xampp\htdocs\gym-booking-system\
   ```

### Step 2: Database Setup

1. **Start XAMPP**:
   - Open XAMPP Control Panel
   - Start Apache and MySQL services

2. **Create Database**:
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Create a new database named `gym_booking_system`
   - Import the SQL file: `database/setup.sql`

3. **Configure Database Connection**:
   - Open `config/database.php`
   - Update database credentials if needed:
   ```php
   private $host = "localhost";
   private $db_name = "gym_booking_system";
   private $username = "root";
   private $password = "";
   ```

### Step 3: File Permissions

Make sure the following directories are writable:
- `uploads/` (for trainer images)
- `logs/` (for error logs)

### Step 4: Access the Application

1. Open your web browser
2. Navigate to: `http://localhost/gym-booking-system/`
3. The application should now be running!

## 📁 Project Structure

```
gym-booking-system/
├── config/
│   └── database.php          # Database configuration
├── database/
│   └── setup.sql            # Database schema and sample data
├── includes/
│   └── functions.php        # Utility functions
├── models/
│   ├── User.php            # User model
│   ├── Trainer.php         # Trainer model
│   └── Booking.php         # Booking model
├── frontend/
│   ├── css/                # CSS files
│   ├── images/             # Image assets
│   └── script/             # JavaScript files
├── index.php               # Homepage
├── login.php               # Login/Registration page
├── dashboard.php           # User dashboard
├── booking.php             # Booking page
├── trainers.php            # Trainers listing
├── pricing.php             # Pricing plans
├── logout.php              # Logout handler
└── newsletter.php          # Newsletter subscription
```

## 🎯 Usage Guide

### For Users

1. **Registration/Login**:
   - Visit the homepage and click "Register Now"
   - Create an account or login with existing credentials

2. **Book a Session**:
   - Navigate to "Book Session" from dashboard
   - Select a trainer, date, and time slot
   - Confirm your booking

3. **View Bookings**:
   - Access your dashboard to see upcoming sessions
   - View booking statistics and recent activity

### For Administrators

1. **Manage Trainers**:
   - Add new trainers through the database or create admin interface
   - Update trainer information and availability

2. **View Bookings**:
   - Access booking data through the database
   - Monitor booking statistics and trends

## 🔧 Configuration

### Email Configuration

To enable email notifications, configure your email settings in `includes/functions.php`:

```php
// Update email configuration in sendBookingConfirmation function
$headers .= 'From: Your Gym <noreply@yourgym.com>' . "\r\n";
```

### Customization

1. **Styling**: Modify CSS files in `frontend/css/`
2. **Functionality**: Update PHP files in root directory
3. **Database**: Modify models in `models/` directory

## 🛡️ Security Features

- **Password Hashing**: All passwords are hashed using PHP's `password_hash()`
- **Input Validation**: All user inputs are validated and sanitized
- **SQL Injection Prevention**: Using prepared statements
- **CSRF Protection**: CSRF tokens for form submissions
- **Session Management**: Secure session handling

## 📱 Responsive Design

The application is fully responsive and works on:
- Desktop computers
- Tablets
- Mobile phones
- All modern browsers

## 🐛 Troubleshooting

### Common Issues

1. **Database Connection Error**:
   - Check if MySQL is running in XAMPP
   - Verify database credentials in `config/database.php`
   - Ensure database `gym_booking_system` exists

2. **Page Not Found**:
   - Make sure Apache is running in XAMPP
   - Check if files are in the correct `htdocs` directory
   - Verify file permissions

3. **Email Not Working**:
   - Configure email settings in `includes/functions.php`
   - Check if your server supports mail() function

4. **Images Not Loading**:
   - Ensure images are in `frontend/images/` directory
   - Check file paths in HTML/PHP files

### Error Logs

Check error logs in:
- XAMPP logs: `C:\xampp\apache\logs\`
- Application logs: `logs/error.log` (if enabled)

## 🔄 Updates & Maintenance

### Regular Maintenance

1. **Database Backups**: Regularly backup your MySQL database
2. **Log Monitoring**: Check error logs for issues
3. **Security Updates**: Keep PHP and dependencies updated
4. **Performance**: Monitor application performance

### Adding New Features

1. **New Pages**: Create PHP files in root directory
2. **New Models**: Add model files in `models/` directory
3. **Styling**: Update CSS files in `frontend/css/`
4. **Database**: Add new tables/columns as needed

## 📞 Support

If you encounter any issues or need help:

1. Check the troubleshooting section above
2. Review error logs
3. Verify all prerequisites are met
4. Ensure proper file permissions

## 📄 License

This project is open source and available under the [MIT License](LICENSE).

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📈 Future Enhancements

- [ ] Admin panel for managing trainers and bookings
- [ ] Payment integration for membership plans
- [ ] Real-time notifications
- [ ] Mobile app development
- [ ] Advanced analytics and reporting
- [ ] Multi-language support
- [ ] Social media integration

---

**Happy Coding! 💪**

## Project
>> Earsplitting-growth-3609

 ![rapid-fit](https://user-images.githubusercontent.com/112810259/229367310-98d1ee3e-8392-46db-83c7-c5ff2b182d78.png)



![33FC57DB-36A7-47B5-A20B-F86C7ABB7EDB](https://user-images.githubusercontent.com/112810259/229417706-587e96d1-4f1f-4715-a722-35566ec9b719.jpg)


<br>

## Project Name
>> Rapit-Fit

# Collaborative Project
 >>Contributors
  - Gunjan Kumar (Team lead)
  - Ajit Kumar Khatua
  - Ayushi Soni
  - Vishal Singh
   

<br>

# DEPLOYED LINK
 - [Frontend](https://chipper-zabaione-4ba9e5.netlify.app/)
 - [Backend](https://good-tan-jay.cyclic.app/)

<hr>

   
   ![WhatsApp Image 2023-04-02 at 10 40 36 PM](https://user-images.githubusercontent.com/112810259/229368310-4371aa39-b0dc-4d7c-8542-65b780611528.jpeg)

   <br>
 # BluePrint and Tasks
 


 # REQUIREMENTS 
  - User can login and sign up 
  - User can visit severals sections
  - User can able to get all the information
  - User can book trainers
  - User can book other services
  - User can book the appointment slot 
  - User can pay for the services
  - User can give feedback on appointment
  - User can choose time according to their needs for slot booking
  - User can cancel the appointment
  - Feedback


  ## TECH STACKS
   # Frontend
    >HTML
    >CSS
    >JAVASCRIPT
    >BOOTSTRAP
    >SWIPERJS
    >CAROUSEL
    >JQUERY

   # Backend
    >NODEJS
    >EXPRESSJS
    >MONGOOSE
    >NODEMAILER
    >JSONWEBTOKEN
    >BCRYPT
    >CORS
    
   # Database
    >MONGODB

   ## Register

    - "https://good-tan-jay.cyclic.app//user/signup"

    * User 
    - Name 
    - Email
    - Password

   ## Login

     - "https://good-tan-jay.cyclic.app//user/login"

     - Email
     - Password
     
     
     
     


     
![login](https://user-images.githubusercontent.com/112810259/229368605-06c4318c-afbb-493e-8fa8-d2ea089f5b9f.png)

## Home Page
 - Navbar -> Home | About | Features | Pricing | Trainers | Register Now
 - Header
 - Footer


 ## About Page
 - Information of variety of trainning
 - About us
 - Trainers Information
 - Customer Reviews

## Features
 - SHOULDER TRAINING MACHINES
 - CHEST AND ARMS TRAINING MACHINES
 - SHOULDER TRAINING MACHINES
 - BACK TRAINING MACHINES
 - CORE TRAINING MACHINES
 - LEG TRAINING FITNESS MACHINES
 - FREE WEIGHTS
 - CARDIO MACHINES
 - HOME GYM
 - ACCESSORIES



  ## Schema
    ## User
    - name  : String
    - email : String
    - password : String
    ## Trainer
    - name : String
    - age : String
    - gender : String
    - image : String
    - price : Number
    - specialization: Array of String
    ## Booking
    - userId : String
    - trainerId : String
    - userEmail : String
    - bookingDate : String
    - bookingSlot : String
 
 ## Booking end points
 - Adding new booking
  - https://good-tan-jay.cyclic.app/booking/create

    - trainerId
    - bookingDate
    - bookingSlot

 - Cancelling the booking
  - https://good-tan-jay.cyclic.app/booking/remove/id

 - Get all booking
  - https://good-tan-jay.cyclic.app/booking

 - Get the booking of paticular user
  - https://good-tan-jay.cyclic.app/booking/userId

 ## Trainer end points
  - Get all trainer
   - https://good-tan-jay.cyclic.app/trainer
  
  - Add new trainer
   - https://good-tan-jay.cyclic.app/trainer/add

      - name 
      - age 
      - gender 
      - image 
      - price 
      - specialization
      
  - Get a paticular trainer by trainerId
    - https://good-tan-jay.cyclic.app/trainer/id

    

    




    


