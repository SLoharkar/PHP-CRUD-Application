<!-- config.php file for Database Connection -->
<?php

session_start(); // Start the session for session variables


// Function to connect mysqli database connection
function database_Connect(){

// Database Credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpdb";

    try {
        // Attempt to connect to MySQL database
        $conn = @new mysqli($servername, $username, $password, $dbname);

        //echo "Connected successfully";

        return $conn;
    } 
    catch (Exception $e) {
        // Catch any exceptions thrown during connection
        echo "Connection failed: " . $e->getMessage();
        exit;
    } 
}

// Function to close database connection
function database_Close($conn){
    if($conn!=null){
        $conn->close();
    }
}

?>