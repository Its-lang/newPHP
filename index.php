<?php
include './include/header.inc.php';
include './include/navbar.inc.php';

$available_pages = ['login', 'register'];

if (isset($_GET['page'])) {
    
    $page = $_GET['page'];

    if(in_array($page, $available_pages)){
        include './pages/' . $page . '.php';
    }
    else{
        echo '<h1>PAGES DOESNT EXITS</h1>';
    }

} else {
    echo '<h1> NOT FOUND </h1>';
}

include './include/footer.inc.php';

?>