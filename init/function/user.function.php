<?php
function createUser($name, $username, $password, $photo){

    global $conn;
    $image_path = null;
    if(!empty($photo['name'])){
        $image_path = uploadImage($photo);
    }
    $query = $conn->prepare('INSERT INTO users (name,username,password,photo) VALUES (?,?,?,?)');
    $query->bind_param('ssss', $name,$username, $password,$image_path);
    $query->execute();
    if ($query->affected_rows > 0) {
        return true;
    }
    return false;
}

function getUser(){
    global $conn;
    $query = $conn -> prepare('SELECT * FROM users WHERE level != "admin"');
    $query -> execute();
    $result = $query -> get_result();
    return $result ;
}
?>