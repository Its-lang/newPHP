<?php
$nameError = $usernameError = $passwdError = '';
$name = $username = '';

if (isset($_POST['username'], $_POST['password'], $_POST['name'], $_FILES['photo'])) {
    $photo = $_FILES['photo'];
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $passwd = trim($_POST['password']);
    if (empty($name)) {
        $nameError = "Name is required";
    }
    
    if (empty($passwd)) {
        $passwdError = "Password is required";
    }
    if (empty($username)) {
        $usernameError = "Username is required";
    }
    if (strlen($passwd) < 6 || strlen($passwd) > 25) {
        $passwdError = "Password must be at least 6 characters";
    }
    if (usernameExist($username)) {
        $usernameError = 'Username is currently unavailable!';
    }
    try{
    if (empty($nameError) && empty($usernameError) && empty($passwdError)) {
        if (createUser($name, $username, $passwd, $photo)) {
            $name = $username = '';
            echo '<div class="alert alert-success" role="alert">
                 Created successful! <a href="./?page=create/list">CLICK LIST</a>
                </div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">
                 Create fail!
                </div>';
        }

    }} catch(Exception $e){
        echo '<div class="alert alert-danger" role="alert">
                 '. $e -> getMessage().'
                </div>';
    }
}
?>

<form method="post" action="./?page=user/create" class="col-md-8 col-lg-6 mx-auto" enctype="multipart/form-data">
    <h3>Create User</h3>
    <div class="d-flex flex-column align-items-center mb-3">
        <input name="photo" type="file" id="profileUpload" hidden accept="image/jpeg,image/png">
        <?php
        $currentUser = handleUserlogin();
        $photoSrc = ($currentUser && !empty($currentUser->photo)) ? $currentUser->photo : './assets/images/emptyuser.png';
        ?>
        <label role="button" for="profileUpload" class="mb-2">
            <img id="profilePreview" src="<?php echo $photoSrc ?>"
                class="rounded img-thumbnail" style="max-width: 200px;">
        </label>
        <small class="text-muted">Click the image to select a photo (jpg/png, max 500KB).</small>
    </div>

    <script>
        document.getElementById('profileUpload').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('profilePreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    </script>
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input name="name" value="<?php echo $name; ?>" type="text" class="form-control
            <?php echo empty($nameError) ? '' : 'is-invalid' ?>">
        <div class="invalid-feedback"><?php echo $nameError; ?></div>
    </div>
    <div class="mb-3">
        <label class="form-label">Username</label>
        <input name="username" value="<?php echo $username; ?>" type="text" class="form-control
            <?php echo empty($usernameError) ? '' : 'is-invalid' ?>">
        <div class="invalid-feedback"><?php echo $usernameError; ?></div>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input name="password" type="password" class="form-control
            <?php echo empty($passwdError) ? '' : 'is-invalid' ?>">
        <div class="invalid-feedback"><?php echo $passwdError; ?></div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>