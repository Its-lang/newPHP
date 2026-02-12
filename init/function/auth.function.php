<?php

function uploadUserImage($file)
{
    global $conn;

    // Basic validation
    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    $max_size = 5 * 1024 * 1024; // 5MB

    // Check file size
    if ($file['size'] > $max_size) {
        return [
            'success' => false,
            'message' => 'File size must not exceed 5MB'
        ];
    }

    // Check file type
    $file_type = mime_content_type($file['tmp_name']);
    if (!in_array($file_type, $allowed_types)) {
        return [
            'success' => false,
            'message' => 'Only JPG, PNG, and GIF images are allowed'
        ];
    }

    // Get file extension
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    // Create unique filename
    $new_filename = $_SESSION['user_id'] . '_' . time() . '.' . $extension;

    // Upload directory
    $upload_dir = "./assets/images/";
    $upload_path = $upload_dir . $new_filename;

    // Get old image
    $old_image = getUserImage($_SESSION['user_id']);

    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $upload_path)) {

        // Update database
        $query = $conn->prepare("UPDATE users SET photo = ? WHERE id = ?");
        $query->bind_param('si', $new_filename, $_SESSION['user_id']);
        $query->execute();

        // Delete old image if exists
        if ($old_image && $old_image !== 'emptyuser.png') {
            $old_path = $upload_dir . $old_image;
            if (file_exists($old_path)) {
                unlink($old_path);
            }
        }

        return [
            'success' => true,
            'message' => 'Image uploaded successfully'
        ];

    } else {
        return [
            'success' => false,
            'message' => 'Failed to upload image'
        ];
    }
}

function getUserImage($user_id)
{
    global $conn;

    $query = $conn->prepare("SELECT photo FROM users WHERE id = ?");
    $query->bind_param('i', $user_id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_object()->photo;
    }

    return null;
}

function deleteUserImage()
{
    global $conn;

    if (!isset($_SESSION['user_id'])) {
        return false;
    }

    $user_id = $_SESSION['user_id'];
    $upload_dir = "./assets/images/";

    // Get current photo
    $query = $conn->prepare("SELECT photo FROM users WHERE id = ?");
    $query->bind_param('i', $user_id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $photo = $result->fetch_object()->photo;

        // Update database
        $updateQuery = $conn->prepare("UPDATE users SET photo = NULL WHERE id = ?");
        $updateQuery->bind_param('i', $user_id);
        $updateQuery->execute();

        // Delete file
        if ($photo && $photo !== 'emptyuser.png') {
            $photo_path = $upload_dir . $photo;
            if (file_exists($photo_path)) {
                unlink($photo_path);
            }
        }

        return true;
    }

    return false;
}

function setUserNewPassword($password)
{
    global $conn;

    $user_id = $_SESSION['user_id'];

    $query = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $query->bind_param('si', $password, $user_id);
    $query->execute();

    if ($conn->affected_rows > 0 || $conn->affected_rows === 0) {
        return true;
    }

    return false;
}

function isUserHasPassword($password)
{
    global $conn;

    $user_id = $_SESSION['user_id'];

    $query = $conn->prepare("SELECT * FROM users WHERE id = ? AND password = ?");
    $query->bind_param('is', $user_id, $password);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        return true;
    }

    return false;
}

function isAdmin()
{
    $user = handleUserlogin();
    if ($user && $user->level == 'admin') {
        return true;
    }
    return false;
}

function handleUserlogin()
{
    global $conn;

    if (!isset($_SESSION['user_id'])) {
        return null;
    }

    $user_id = $_SESSION["user_id"];

    $sql = $conn->prepare('SELECT * FROM users WHERE id = ?');

    $sql->bind_param('i', $user_id);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows) {
        return $result->fetch_object();
    }

    return null;
}

function loginUser($username, $password)
{
    global $conn;

    $sql = $conn->prepare('SELECT * FROM users WHERE username = ? AND password = ? ');

    $sql->bind_param('ss', $username, $password);

    $sql->execute();

    $result = $sql->get_result();

    if ($result->num_rows === 0) {
        return false;
    }
    $user = $result->fetch_object();
    return $user;
}


function usrnameExists($username)
{

    global $conn;

    $query = $conn->prepare('SELECT * FROM users WHERE username = ?');

    $query->bind_param('s', $username);

    $query->execute();

    $result = $query->get_result();

    if ($result->num_rows) {
        return true;
    }
    return false;
}

function registerUser($name, $username, $password)
{
    global $conn;

    $query = $conn->prepare('INSERT INTO users (name , username, password) VALUES(?,?,?)');

    $query->bind_param('sss', $name, $username, $password);

    $query->execute();

    if ($conn->affected_rows) {
        return true;
    }
    return false;
}

?>