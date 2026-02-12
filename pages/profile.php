<?php

$oldPassword = $newPassword = $confirmNewPassword = '';
$oldPasswordErr = '';
$newPasswordErr = '';

if (isset($_POST['changePassword'])) {
    
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

    if (empty($oldPassword)) {
        $oldPasswordErr = 'Please enter old password';
    }

    if (empty($newPassword)) {
        $newPasswordErr = 'Please enter new password';
    }

    if ($newPassword != $confirmNewPassword) {
        $newPasswordErr = 'Passwords do not match';
    }

    if (empty($oldPasswordErr) && empty($newPasswordErr)) {
        
        if (isUserHasPassword($oldPassword)) {
            
            if (setUserNewPassword($newPassword)) {
            
                unset($_SESSION['user_id']);
                echo '<div class="alert alert-success">Password changed successfully! <a href="./?page=login">Login again</a></div>';
            } else {
                echo '<div class="alert alert-danger">Failed to update password</div>';
            }
            
        } else {
            $oldPasswordErr = 'Old password is incorrect';
        }
    }
}

// Show any messages
if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}

// Get user photo
$photo = getUserImage($_SESSION['user_id']);
if (empty($photo)) {
    $photo = 'emptyuser.png';
}

// Handle photo upload
if (isset($_POST['uploadPhoto'])) {
    
    if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
        
        $result = uploadUserImage($_FILES["photo"]);
        
        if ($result['success']) {
            $_SESSION['message'] = '<div class="alert alert-success">Image uploaded successfully!</div>';
        } else {
            $_SESSION['message'] = '<div class="alert alert-danger">' . $result['message'] . '</div>';
        }
        
        header('Location: ./?page=profile');
        exit();
    } else {
        $_SESSION['message'] = '<div class="alert alert-danger">Please select an image file</div>';
        header('Location: ./?page=profile');
        exit();
    }
}

// Handle photo delete
if (isset($_POST['deletePhoto'])) {
    
    if (deleteUserImage()) {
        $_SESSION['message'] = '<div class="alert alert-success">Image deleted successfully!</div>';
    } else {
        $_SESSION['message'] = '<div class="alert alert-danger">Failed to delete image</div>';
    }
    
    header('Location: ./?page=profile');
    exit();
}

?>

<div class="row">
    <!-- Photo Section -->
    <div class="col-6">
        <form method="post" action="./?page=profile" enctype="multipart/form-data" id="photoForm">
            
            <div class="d-flex justify-content-center">
                <input name="photo" type="file" id="profileUpload" accept="image/*" hidden>
                <label for="profileUpload" style="cursor: pointer;">
                    <img src="./assets/images/<?php echo $photo; ?>" 
                         id="previewImage"
                         class="rounded" 
                         style="width: 300px; height: 300px; object-fit: cover;">
                </label>
            </div>
            
            <div class="d-flex justify-content-center mt-3">
                <button type="submit" name="deletePhoto" id="deleteBtn" class="btn btn-danger me-2" 
                        <?php echo ($photo == 'emptyuser.png') ? 'disabled' : ''; ?>>
                    Delete
                </button>
                <button type="submit" name="uploadPhoto" id="uploadBtn" class="btn btn-success">
                    Upload
                </button>
            </div>
            
        </form>
    </div>

    <!-- Password Section -->
    <div class="col-6">
        <form method="post" action="./?page=profile">
            
            <h3>Change Password</h3>
            
            <div class="mb-3">
                <label class="form-label">Old Password</label>
                <input name="oldPassword" 
                       type="password" 
                       class="form-control <?php echo $oldPasswordErr ? 'is-invalid' : ''; ?>">
                <?php if ($oldPasswordErr): ?>
                    <div class="invalid-feedback"><?php echo $oldPasswordErr; ?></div>
                <?php endif; ?>
            </div>
            
            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input name="newPassword" 
                       type="password" 
                       class="form-control <?php echo $newPasswordErr ? 'is-invalid' : ''; ?>">
                <?php if ($newPasswordErr): ?>
                    <div class="invalid-feedback"><?php echo $newPasswordErr; ?></div>
                <?php endif; ?>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Confirm New Password</label>
                <input name="confirmNewPassword" type="password" class="form-control">
            </div>
            
            <button type="submit" name="changePassword" class="btn btn-primary">Change Password</button>
            
        </form>
    </div>
</div>

<script>
// Simple image preview
document.getElementById('profileUpload').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const uploadBtn = document.getElementById('uploadBtn');
    
    if (file) {
        // Show preview
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('previewImage').src = event.target.result;
        };
        reader.readAsDataURL(file);
        
        // Enable upload button
        uploadBtn.disabled = false;
    } else {
        // Disable upload button if no file
        uploadBtn.disabled = true;
    }
});

// Check before submit
document.getElementById('photoForm').addEventListener('submit', function(e) {
    const fileInput = document.getElementById('profileUpload');
    
    // Check if trying to upload
    if (e.submitter.name === 'uploadPhoto') {
        // Check if no file selected
        if (!fileInput.files || !fileInput.files.length) {
            e.preventDefault();
            alert('Please select a photo first!');
            return false;
        }
    }
    
    // Check if trying to delete
    if (e.submitter.name === 'deletePhoto') {
        if (!confirm('Are you sure you want to delete your photo?')) {
            e.preventDefault();
            return false;
        }
    }
});
</script>