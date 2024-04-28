<?php 
include("config/database.php");
session_destroy();
header("Location: index.php");
?>