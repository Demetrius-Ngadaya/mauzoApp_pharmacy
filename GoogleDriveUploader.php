<?php
require_once 'vendor/autoload.php'; // Composer autoload

class GoogleDriveUploader {
    private $client;
    private $service;
    
    public function __construct() {
        $this->client = new Google_Client();
        $this->client->setApplicationName('Pharmacy DB Backup');
        $this->client->setScopes(Google_Service_Drive::DRIVE_FILE);
        $this->client->setAuthConfig('credentials.json'); // Service account credentials
        $this->client->setAccessType('offline');
        
        $this->service = new Google_Service_Drive($this->client);
    }
    
    public function uploadFile($filePath, $targetEmail) {
        try {
            $fileMetadata = new Google_Service_Drive_DriveFile([
                'name' => basename($filePath),
                'parents' => ['root']
            ]);
            
            $content = file_get_contents($filePath);
            $file = $this->service->files->create($fileMetadata, [
                'data' => $content,
                'mimeType' => 'application/sql',
                'uploadType' => 'multipart',
                'fields' => 'id'
            ]);
            
            // Share with target email
            $permission = new Google_Service_Drive_Permission([
                'type' => 'user',
                'role' => 'writer',
                'emailAddress' => $targetEmail
            ]);
            
            $this->service->permissions->create($file->id, $permission);
            
            return true;
        } catch (Exception $e) {
            error_log('Google Drive upload failed: ' . $e->getMessage());
            return false;
        }
    }
}
?>