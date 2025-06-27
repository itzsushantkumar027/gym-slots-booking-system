<?php
require_once __DIR__ . '/../config/database.php';

class Booking {
    private $conn;
    private $table_name = "bookings";

    public $id;
    public $user_id;
    public $trainer_id;
    public $user_email;
    public $booking_date;
    public $booking_slot;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create new booking
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (user_id, trainer_id, user_email, booking_date, booking_slot, status) VALUES (:user_id, :trainer_id, :user_email, :booking_date, :booking_slot, :status)";
        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->trainer_id = htmlspecialchars(strip_tags($this->trainer_id));
        $this->user_email = htmlspecialchars(strip_tags($this->user_email));
        $this->booking_date = htmlspecialchars(strip_tags($this->booking_date));
        $this->booking_slot = htmlspecialchars(strip_tags($this->booking_slot));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind parameters
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":trainer_id", $this->trainer_id);
        $stmt->bindParam(":user_email", $this->user_email);
        $stmt->bindParam(":booking_date", $this->booking_date);
        $stmt->bindParam(":booking_slot", $this->booking_slot);
        $stmt->bindParam(":status", $this->status);

        if($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Get all bookings
    public function getAll() {
        $query = "SELECT b.*, u.name as user_name, t.name as trainer_name 
                  FROM " . $this->table_name . " b 
                  LEFT JOIN users u ON b.user_id = u.id 
                  LEFT JOIN trainers t ON b.trainer_id = t.id 
                  ORDER BY b.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Get bookings by user ID
    public function getByUserId($user_id) {
        $query = "SELECT b.*, t.name as trainer_name, t.image as trainer_image 
                  FROM " . $this->table_name . " b 
                  LEFT JOIN trainers t ON b.trainer_id = t.id 
                  WHERE b.user_id = ? 
                  ORDER BY b.booking_date ASC, b.booking_slot ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $user_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get bookings by trainer ID
    public function getByTrainerId($trainer_id) {
        $query = "SELECT b.*, u.name as user_name, u.email as user_email 
                  FROM " . $this->table_name . " b 
                  LEFT JOIN users u ON b.user_id = u.id 
                  WHERE b.trainer_id = ? 
                  ORDER BY b.booking_date ASC, b.booking_slot ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $trainer_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get booking by ID
    public function getById($id) {
        $query = "SELECT b.*, u.name as user_name, t.name as trainer_name 
                  FROM " . $this->table_name . " b 
                  LEFT JOIN users u ON b.user_id = u.id 
                  LEFT JOIN trainers t ON b.trainer_id = t.id 
                  WHERE b.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Check if slot is available
    public function isSlotAvailable($trainer_id, $booking_date, $booking_slot) {
        $query = "SELECT id FROM " . $this->table_name . " WHERE trainer_id = ? AND booking_date = ? AND booking_slot = ? AND status != 'cancelled'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $trainer_id);
        $stmt->bindParam(2, $booking_date);
        $stmt->bindParam(3, $booking_slot);
        $stmt->execute();

        return $stmt->rowCount() == 0;
    }

    // Update booking status
    public function updateStatus($id, $status) {
        $query = "UPDATE " . $this->table_name . " SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $status);
        $stmt->bindParam(2, $id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Update booking
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET user_id = :user_id, trainer_id = :trainer_id, user_email = :user_email, booking_date = :booking_date, booking_slot = :booking_slot, status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->trainer_id = htmlspecialchars(strip_tags($this->trainer_id));
        $this->user_email = htmlspecialchars(strip_tags($this->user_email));
        $this->booking_date = htmlspecialchars(strip_tags($this->booking_date));
        $this->booking_slot = htmlspecialchars(strip_tags($this->booking_slot));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind parameters
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':trainer_id', $this->trainer_id);
        $stmt->bindParam(':user_email', $this->user_email);
        $stmt->bindParam(':booking_date', $this->booking_date);
        $stmt->bindParam(':booking_slot', $this->booking_slot);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete booking
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Get upcoming bookings
    public function getUpcomingBookings($user_id = null, $trainer_id = null) {
        $where_clause = "WHERE b.booking_date >= CURDATE() AND b.status != 'cancelled'";
        
        if($user_id) {
            $where_clause .= " AND b.user_id = " . intval($user_id);
        }
        
        if($trainer_id) {
            $where_clause .= " AND b.trainer_id = " . intval($trainer_id);
        }

        $query = "SELECT b.*, u.name as user_name, t.name as trainer_name, t.image as trainer_image 
                  FROM " . $this->table_name . " b 
                  LEFT JOIN users u ON b.user_id = u.id 
                  LEFT JOIN trainers t ON b.trainer_id = t.id 
                  " . $where_clause . " 
                  ORDER BY b.booking_date ASC, b.booking_slot ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get booking statistics
    public function getStatistics($user_id = null) {
        $where_clause = "";
        if($user_id) {
            $where_clause = "WHERE user_id = " . intval($user_id);
        }

        $query = "SELECT 
                    COUNT(*) as total_bookings,
                    COUNT(CASE WHEN status = 'confirmed' THEN 1 END) as confirmed_bookings,
                    COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_bookings,
                    COUNT(CASE WHEN status = 'cancelled' THEN 1 END) as cancelled_bookings,
                    COUNT(CASE WHEN booking_date >= CURDATE() THEN 1 END) as upcoming_bookings
                  FROM " . $this->table_name . " " . $where_clause;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?> 