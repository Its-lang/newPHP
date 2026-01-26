<?php
include './include/header.inc.php';
include './include/navbar.inc.php';
require_once './init/init.php';

$nameError = $usernameError = $passwdError = $confirmpasswordError = '';
$name = $username = '';

if (isset($_POST['username'], $_POST['password'], $_POST['confirmpassword'], $_POST['name'])) {

    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $cf_password = $_POST['confirmpassword'];

    if (empty($name)) {
        $nameError = "NAME_IS_REQUUIRED";
    }
    if (empty($password)) {
        $passwdError = "PASSWORD_IS_REQUIRED";
    }
    if (empty($username)) {
        $usernameError = "USERNAME_IS_REQUUIRED";
    }
    if (strlen($password) > 25 || strlen($password) < 6) {
        $passwdError = 'PASSWORD_LENGTH_SHOULD_BE_6_TO_25';
    }
    if ($password !== $cf_password) {
        $passwdError = 'PASSWORD_DOES_NOT_MATCH';
    }
    if (usrnameExists($username)) {
        $usernameError = 'USERNAME_ALLREADY_EXISTS';
    }
    if (empty($nameError) && empty($usernameError) && empty($passwdError)) {

        if (registerUser($name, $username, $password)) {

            $name = $username = ''; 

            echo '<div class="alert alert-success" role="alert">
                    register success!
                    <a href = "./?page = login" class = "alert-link">
                  </div>';
        } else {
            echo '<div class="alert alert-success" role="alert">
                    A simple success alert—check it out!
                  </div>';
        }
    }
}
?>

<form method="post" action="./?page=register" class="col-md-8 col-lg-6 mx-auto">
    <h3>Register</h3>
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
    <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input name="confirmpassword" type="password" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>