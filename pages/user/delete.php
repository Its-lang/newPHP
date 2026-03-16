<?php 
$id = $_GET["id"];
$targetUser = readUser($id);
if ($targetUser = null || $targetUser->level == "admin") {
    header("Location: ./?page=user/list");
}else{
    if(deleteUser($id)){
         echo '<div class="alert alert-success" role="alert">
                 Delete successful! <a href="./?page=create/list">CLICK LIST</a>
                </div>';

    } else{
         echo '<div class="alert alert-success" role="alert">
                 deleted fail! <a href="./?page=create/list">CLICK LIST</a>
                </div>';

    }
}


?>