<?php

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