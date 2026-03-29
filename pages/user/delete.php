<?php
$id = $_GET['id'];
$targetUser = readUser($id);
if($targetUser == null || $targetUser->level == 'admin'){
    header('Location: ./?page=user/list');
}
if(deleteUser($id)){
    header('Location:./?page=user/list');
    
} else {
    echo '<div class="alert alert-danger" role="alert">
             Delete fail!
            </div>';
}


?>