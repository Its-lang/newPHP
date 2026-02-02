<?php

require_once './init/init.php';
$user = handleUserlogin();
include './include/header.inc.php';
include './include/navbar.inc.php';


$available_pages = ['login', 'register','logout' ,'dashboard'];
$login_in_page = ['dashboard'];
$non_login_in_page = ['login', 'register'];

$page = '';

if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

if (in_array($page, $login_in_page) && empty($user)) {
    header('Location: ./?page=login');
}

if (in_array($page, $non_login_in_page) && !empty($user)) {
    header('Location: ./?page=dashboard');
}

if (in_array($page, $available_pages)) {
    include './pages/' . $page . '.php';
} else {
    header('Location: ./?page=dashboard');
}


// if (isset($_GET['page'])) {

//     $page = $_GET['page'];

//     if(in_array($page, $available_pages)){
//         include './pages/' . $page . '.php';
//     }
//     else{
//         echo '<h1>PAGES DOESNT EXITS</h1>';
//     }

// } else {
//     echo '<h1> NOT FOUND </h1>';
// }

include './include/footer.inc.php';

?>