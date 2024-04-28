<?php 
    if(isset($_SESSION['user_login_status'])){
        return true;
    }
    else{
        header("Location: index.php");
    }
?>