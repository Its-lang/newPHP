<?php
require_once './init/init.php';
$user = handleUserlogin();
$isAdmin = isAdmin();
include './includes/header.inc.php';
include './includes/novbar.inc.php';
// $_GET['pages'];
// include_once './pages/'.$_GET['pages'].'.php';

$admin_pages = ['user/create', 'user/list', 'user/update', 'user/delete']; //pages only for admin users
$logged_in_pages = ['dashboard', 'profile']; //pages only for logged in users
$non_logged_in_pages = ['login', 'register']; //pages only for non-logged in users
$available_pages = [
    'logout',
    ...$non_logged_in_pages,
    ...$logged_in_pages,
    ...$admin_pages
    ]; //create array //available pages by merging all pages

$page = ''; //default page
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
if (in_array($page, $logged_in_pages) && empty($user)) {
    //redirect to login page
    header('Location: ./?page=login');
}
if (in_array($page, $non_logged_in_pages) && !empty($user)) {
    //redirect to dashboard page
    header('Location: ./?page=dashboard');
}
if(in_array($page, $available_pages)){
    if(in_array($page, $admin_pages) && !$isAdmin){
        header('Location: ./?page=dashboard');
    }
}
if (in_array($page, $available_pages)) {
    include_once './pages/' . $page . '.php';
} else {
    // header('Location: ./?page=login');
    header('Location: ./?page=dashboard'); // Header is used to redirect to dashboard by default
    // include_once './pages/' . 'dashboard' . '.php';
}

include './includes/footer.inc.php';
?>