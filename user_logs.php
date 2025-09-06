<?php
include("dbcon.php");

class UserLogger {
    private $con;
    
    public function __construct($connection) {
        $this->con = $connection;
    }
    
    // Record user login
    public function logLogin($user_id, $store_id) {
        $log_in_time = date('Y-m-d H:i:s');
        
        $sql = "INSERT INTO user_logs (user_id, store_id, log_in_time) 
                VALUES (?, ?, ?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("iis", $user_id, $store_id, $log_in_time);
        
        if ($stmt->execute()) {
            return $this->con->insert_id;
        }
        return false;
    }
    
    // Record user logout
    public function logLogout($user_id) {
        $log_out_time = date('Y-m-d H:i:s');
        
        // Find the most recent login record without logout time
        $sql = "SELECT id FROM user_logs 
                WHERE user_id = ? AND log_out_time IS NULL 
                ORDER BY log_in_time DESC LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $log_id = $row['id'];
            
            // Update the logout time
            $update_sql = "UPDATE user_logs SET log_out_time = ? WHERE id = ?";
            $update_stmt = $this->con->prepare($update_sql);
            $update_stmt->bind_param("si", $log_out_time, $log_id);
            
            return $update_stmt->execute();
        }
        return false;
    }
    
    // Get user login history
    public function getUserLogs($user_id = null, $limit = 50) {
        $sql = "SELECT ul.*, u.user_name, s.name as store_name 
                FROM user_logs ul 
                JOIN users u ON ul.user_id = u.id 
                JOIN stores s ON ul.store_id = s.id";
        
        if ($user_id) {
            $sql .= " WHERE ul.user_id = ?";
        }
        
        $sql .= " ORDER BY ul.log_in_time DESC LIMIT ?";
        
        $stmt = $this->con->prepare($sql);
        
        if ($user_id) {
            $stmt->bind_param("ii", $user_id, $limit);
        } else {
            $stmt->bind_param("i", $limit);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        $logs = [];
        while ($row = $result->fetch_assoc()) {
            $logs[] = $row;
        }
        
        return $logs;
    }
}
?>