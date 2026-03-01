<?php

function isAdmin(){
    $user = handleUserlogin();
    if($user && $user->level === 'admin'){
        return true;
    }
    return false;
}
function isUserHasPassword($passwd){
    global $conn;
    $user = handleUserlogin();
    $query = $conn->prepare('SELECT * FROM tbl_users WHERE id = ? AND passwd = ?');
    $query->bind_param('ds', $user->id, $passwd);
    $query->execute();
    $result = $query->get_result();
    if($result->num_rows){
        return true;
    }
    return false;
}
function setUserNewPassword($passwd){
    global $conn;
    $user = handleUserlogin();
    $query = $conn->prepare('UPDATE users SET password = ? WHERE id = ?');
    $query->bind_param('sd',$passwd,$user->id);
    $query->execute();
    if($conn->affected_rows){
        return true;
    }
    return false;

}
function changeProfileImage($image){
    global $conn;
    $user = handleUserlogin();
    $image_path = uploadImage($image);
    if($image_path && $user->photo){
        unlink($user->photo);
    }
    $query = $conn->prepare('UPDATE tbl_users SET photo = ? WHERE id = ?');
    $query->bind_param('sd', $image_path, $user->id);
    $query->execute();
    if($conn->affected_rows){
        return true;
    }
    return false;
}
function deleteProfileImage(){
    global $conn;
    $user = handleUserlogin();
    if($user->photo){
        unlink($user->photo);
    }
    $query = $conn->prepare('UPDATE tbl_users SET photo = NULL WHERE id = ?');
    $query->bind_param('d', $user->id);
    $query->execute();
    if($conn->affected_rows){
        return true;
    }
    return false;
    
}
function uploadImage($image)
{
    $img_name = $image['name'];
    $img_size = $image['size'];
    $tmp_name = $image['tmp_name'];
    $error = $image['error'];

    $dir = './assets/images/';

    $allow_exs = ['jpg', 'png', 'jpeg'];
    $image_ex = pathinfo($img_name, PATHINFO_EXTENSION);
    $image_lowercase_ex = strtolower($image_ex);

    if (!in_array($image_lowercase_ex, $allow_exs)) {
        throw new Exception('File extension is not allowed!');
    }

    if ($error !== 0) {
        throw new Exception('Unknown error occurred!');
    }

    if ($img_size > 500000) {
        throw new Exception('File size is too large!');
    }

    $new_image_name = uniqid("PI-") . '.' . $image_lowercase_ex;
    $image_path = $dir . $new_image_name;
    move_uploaded_file($tmp_name, $image_path);
    return $image_path;
}
function handleUserlogin(){
    global $conn;

    if(!isset($_SESSION['user_id'])) {
        return null;
    }

    $user_id = $_SESSION["user_id"];

    $sql = $conn->prepare('SELECT * FROM users WHERE id = ?');

    $sql->bind_param('d', $user_id);
    $sql->execute();
    $result = $sql->get_result();

    if($result->num_rows){
        return $result->fetch_object();
    }

    return null;
}

function loginUser($username, $password){
    global $conn;

    $sql = $conn -> prepare('SELECT * FROM users where username = ? and password = ? ');

    $sql -> bind_param('ss', $username, $password);

    $sql -> execute();

    $result = $sql -> get_result();

    if ($result->num_rows === 0) {
        return false;
    }
    $user = $result->fetch_object();
    return $user;
}


function usrnameExists($username){
    
    global $conn;

    $query = $conn -> prepare('SELECT * FROM users WHERE username = ?');

    $query -> bind_param('s', $username);

    $query -> execute();

    $result = $query -> get_result();

    if($result -> num_rows){
        return true;
    }return false;
}

function registerUser($name, $username, $password){
    global $conn;

    $query = $conn -> prepare('INSERT INTO users (name , username, password) VALUES(?,?,?)');

    $query -> bind_param('sss', $name , $username, $password);

    $query -> execute();

    if($conn -> affected_rows){
        return true;
    }return false;
}

?>