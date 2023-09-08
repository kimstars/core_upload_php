<?php

require 'vendor/autoload.php';

require_once 'dbConfig.php';


if (isset($_POST['submit'])) {

    $clientSecretPath = './secret1.json';

    // Khởi tạo Client
    $client = new Google_Client();
    $client->setAuthConfig($clientSecretPath);
    $client->setScopes(Google_Service_Drive::DRIVE);
    // Tạo đối tượng Drive
    $driveService = new Google_Service_Drive($client);

    // Validate form input fields
    if (empty($_FILES['file']['name'])) {
        $valErr .= 'Please select a file to upload.<br/>';
    }

    // Check whether user inputs are empty
    if (empty($valErr)) {
        if($_FILES['file']['size'] < 10485760){

        $fileName = basename($_FILES['file']['name']);

        $filePath = $_FILES['file']['tmp_name'];


        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $fileName,
        ]);

        $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg');
        $minetype = mime_content_type($filePath);

        // Tải tệp lên Google Drive
        try {
            $content = file_get_contents($filePath);
            $file = $driveService->files->create($fileMetadata, [
                'data' => $content,
                'mimeType' => $minetype,
                'uploadType' => 'multipart',
                'fields' => 'id',
            ]);
            
            // The ID of the uploaded file
            $fileId = $file->id;

            // Set permissions to allow anyone to read the file
            $permission = new Google_Service_Drive_Permission([
                'type' => 'anyone',
                'role' => 'reader',
            ]);

            $driveService->permissions->create($fileId, $permission);

            if ($fileId) {
                $sqlQ = 'INSERT INTO drive_files (file_name,created,google_drive_file_id) VALUES (?,NOW(),?)';

                $stmt = $db->prepare($sqlQ);
                $stmt->bind_param('ss', $fileName, $fileId);
                $insert = $stmt->execute();


                $status = 'success';
                $statusMsg =
                    '<p>File has been uploaded to Google Drive successfully!</p>';
                $statusMsg .=
                    '<p><a href="https://drive.google.com/open?id=' .
                    $fileId .
                    '" target="_blank">' .
                    $fileName .
                    '</a>';
            }

        } catch (Exception $e) {
            print "An error occurred: " . $e->getMessage();
        }
    }else{
        $status = 'Error';
        $statusMsg =
        '<p>Limit upload size 10MB !</p>';
    }


    }

}

$_SESSION['status_response'] = [
    'status' => $status,
    'status_msg' => $statusMsg,
];

header('Location: index.php');
exit();

?>