<?php
if (isset($_SESSION['user_id'])) {
    echo $_SESSION['user_id'];
} 

echo 'LEVEL: ' . (isAdmin() ? 'Admin' : 'User');

// if(isAdmin()){   show admin or user level
//     echo'LEVEL : Admin'; 
// }else{
//     echo 'LEVEL : User';
// }
?>

<h1>Dashboard</h1>