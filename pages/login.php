<?php
$username = '';
$usernameError = $passwordError = "";

if (isset($_POST['username'], $_POST['password'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($password)) {
        $passwdError = "PASSWORD_IS_REQUIRED";
    }

    if (empty($username)) {
        $usernameError = "USERNAME_IS_REQUUIRED";
    }

    if(empty($usernameError) && empty($passwordError)){

      $user = loginUser($username, $password);

      if($user !== false){
        $_SESSION['user_id'] = $user -> id;
        header('Location: ./?page = dashboard');
      }else{
        $username = 'Username or password is incorrect';
      }
    }
  }
?>

<form method="post" action="./?page=login" class="col-md-6 col-lg-6 mx-auto my-5">
  <h3>Login Page</h3>

  <div class="mb-3">
    <label class="form-label">Username</label>
    <input name="username" value="<?php echo $username; ?>" type="text"
      class="form-control <?php echo empty($usernameError) ? '' : 'is-invalid'; ?>">
    <div class="invalid-feedback"><?php echo $usernameError; ?></div>
  </div>

  <div class="mb-3">
    <label class="form-label">Password</label>
    <input name="password" type="password"
      class="form-control <?php echo empty($passwordError) ? '' : 'is-invalid'; ?>">
    <div class="invalid-feedback"><?php echo $passwordError; ?></div>
  </div>

  <button type="submit" class="btn btn-primary">Login</button>
</form>