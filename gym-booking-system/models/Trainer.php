<?php
require_once __DIR__ . '/../config/database.php';

class Trainer {
    private $conn;
    private $table_name = "trainers";

    public $id;
    public $name;
    public $age;
    public $gender;
    public $image;
    public $price;
    public $specialization;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create new trainer
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (name, age, gender, image, price, specialization) VALUES (:name, :age, :gender, :image, :price, :specialization)";
        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->age = htmlspecialchars(strip_tags($this->age));
        $this->gender = htmlspecialchars(strip_tags($this->gender));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->specialization = htmlspecialchars(strip_tags($this->specialization));

        // Bind parameters
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":age", $this->age);
        $stmt->bindParam(":gender", $this->gender);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":specialization", $this->specialization);

        if($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Get all trainers
    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Get trainer by ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update trainer
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET name = :name, age = :age, gender = :gender, image = :image, price = :price, specialization = :specialization WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->age = htmlspecialchars(strip_tags($this->age));
        $this->gender = htmlspecialchars(strip_tags($this->gender));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->specialization = htmlspecialchars(strip_tags($this->specialization));

        // Bind parameters
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':age', $this->age);
        $stmt->bindParam(':gender', $this->gender);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':specialization', $this->specialization);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete trainer
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Get trainer with time slots
    public function getWithTimeSlots($id) {
        $query = "SELECT t.*, ts.id as slot_id, ts.start_time, ts.end_time, ts.is_booked 
                  FROM " . $this->table_name . " t 
                  LEFT JOIN time_slots ts ON t.id = ts.trainer_id 
                  WHERE t.id = ? 
                  ORDER BY ts.start_time ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update time slot booking status
    public function updateTimeSlot($slot_id, $is_booked) {
        $query = "UPDATE time_slots SET is_booked = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $is_booked);
        $stmt->bindParam(2, $slot_id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Get available time slots for a trainer on a specific date
    public function getAvailableSlots($trainer_id, $date) {
        $query = "SELECT ts.* FROM time_slots ts 
                  LEFT JOIN bookings b ON ts.trainer_id = b.trainer_id 
                  AND ts.start_time = TIME(b.booking_slot) 
                  AND b.booking_date = ? 
                  WHERE ts.trainer_id = ? 
                  AND b.id IS NULL 
                  ORDER BY ts.start_time ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $date);
        $stmt->bindParam(2, $trainer_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?> 