<?php

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