<?php

require_once './init/init.php';
$user = handleUserlogin();
$isAdmin = isAdmin();
include './include/header.inc.php';
include './include/navbar.inc.php';

$admin_pages = ['user/create', 'user/list', 'user/update', 'user/delete'];
$login_in_page = ['dashboard', 'profile'];
$non_login_in_page = ['login', 'register'];
$available_pages = ['logout', ...$login_in_page, ...$non_login_in_page, ...$admin_pages];

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

if(in_array($page, $available_pages)){
    if(in_array($page, $admin_pages) && !$isAdmin){
        header('Location: ./?page=dashboard');
    }
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