<?php
require_once 'vendor/autoload.php';
$clientSecretPath = './secret1.json';

// Set your Google API credentials
$client = new Google_Client();
$client->setAuthConfig($clientSecretPath); // Replace with your Client Secret JSON file
$client->addScope(Google_Service_Drive::DRIVE_READONLY);

// Set up the Google Drive service
$driveService = new Google_Service_Drive($client);

// List files from Google Drive
$results = $driveService->files->listFiles(array(
    'q' => "'me' in owners", // List files owned by your account
));


if (count($results->getFiles()) == 0) {
    $status = 'Error';
    echo "No files found.";
} else {
 
    echo "Files:\n";
    foreach ($results->getFiles() as $file) {
        echo '<p><a href="https://drive.google.com/open?id=' . $file->getId() . '" target="_blank">'.$file->getName() .'</a>'. " ==> MineType : ". $file->getMimeType() .". ID = ". $file->getId()."</p>";
    }
}



?>