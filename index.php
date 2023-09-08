<?php 
// Include configuration file 


include_once 'config.php'; 
 
$status = $statusMsg = ''; 
if(!empty($_SESSION['status_response'])){ 
    $status_response = $_SESSION['status_response']; 
    $status = $status_response['status']; 
    $statusMsg = $status_response['status_msg']; 
     
    unset($_SESSION['status_response']); 
} 
?>

<!-- Status message -->
<?php if(!empty($statusMsg)){ ?>
    <div class="alert alert-<?php echo $status; ?>"><?php echo $statusMsg; ?></div>
<?php } ?>

<div class="col-md-12">
    <form method="post" action="upload.php" class="form" enctype="multipart/form-data">
        <label>Upload</label>
        <div class="form-group">
            <input type="file" name="file" class="form-control">
        </div>
        <div class="form-group">
            <input type="submit" class="form-control btn-primary" name="submit" value="Upload"/>
        </div>
    </form>
</div>

<div class="col-md-12">
    <form method="post" action="ListFile.php" class="form" enctype="multipart/form-data">
        <label>Get ListFile</label>
        <div class="form-group">
            <input type="submit" class="form-control btn-primary" name="submit" value="GetLIST"/>
        </div>
    </form>
</div>

<div class="col-md-12">
    <form method="get" action="DeleteFile.php" class="form" enctype="multipart/form-data">
        <div class="form-group">
            <label>Delete by fileID</label>
            <input type="input" name="id" class="form-control">
        </div>
        <div class="form-group">
            <input type="submit" class="form-control btn-primary" name="submit" value="Delete"/>
        </div>
    </form>
</div>