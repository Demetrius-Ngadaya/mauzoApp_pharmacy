<?php
// Database configuration
$host = "localhost";
$user = "root";
$password = "";
$dbname = "pharmacy";

// Backup directory
$backupDir = __DIR__ . '/backups/';
if (!file_exists($backupDir)) {
    mkdir($backupDir, 0755, true);
}

// Google Drive configuration
$googleDriveEmail = 'demetrusngadaya@gmail.com';

// Create backup filename with timestamp
$backupFile = $backupDir . $dbname . '_' . date("Y-m-d_H-i-s") . '.sql';

// MySQL dump command
$command = "mysqldump --host=$host --user=$user --password=$password $dbname > $backupFile";

// Execute the command
system($command, $output);

if ($output === 0) {
    // Backup successful - now upload to Google Drive
    
    // Method 1: Using Google Drive API (recommended)
    require_once 'GoogleDriveUploader.php'; // You'll need to create this
    
    $drive = new GoogleDriveUploader();
    $drive->uploadFile($backupFile, $googleDriveEmail);
    
    // Method 2: Using rclone (alternative)
    // system("rclone copy $backupFile remote:backups/");
    
    // Clean up - delete local backup after 7 days
    $files = glob($backupDir . '*.sql');
    foreach ($files as $file) {
        if (filemtime($file) < time() - 7 * 24 * 60 * 60) {
            unlink($file);
        }
    }
    
    // Log the backup
    file_put_contents($backupDir . 'backup.log', date('Y-m-d H:i:s') . " - Backup successful\n", FILE_APPEND);
} else {
    // Log the error
    file_put_contents($backupDir . 'backup.log', date('Y-m-d H:i:s') . " - Backup failed\n", FILE_APPEND);
}
?>