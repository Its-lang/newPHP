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
    <div class="d-flex justify-content-center">
        <input name="photo" type="file" id="profileUpload" hidden>
        <label role="button" for="profileUpload">
            <img src="<?php echo loggedInUser()->photo ?? './assets/images/emptyuser.png' ?>"
                class="rounded img-thumbnail" style="max-width: 200px;">
        </label>
    </div>
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