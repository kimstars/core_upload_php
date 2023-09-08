<?php
require_once 'vendor/autoload.php';


if(isset($_GET['id'])){

    // Set your Google API credentials
    $client = new Google_Client();
    $client->setAuthConfig('./secret1.json'); // Replace with your Client Secret JSON file
    $client->addScope(Google_Service_Drive::DRIVE);

    // Set up the Google Drive service
    $driveService = new Google_Service_Drive($client);

    $fileId = $_GET['id'];

    try {
        $driveService->files->delete($fileId);
        
        echo 'File with ID '.$fileId.' has been deleted successfully.';

    } catch (Google_Service_Exception $exception) {
       
        echo "An error occurred: " . $exception->getMessage();
    }

}



?>
