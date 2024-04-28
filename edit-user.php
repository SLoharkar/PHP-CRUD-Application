<?php
// Include Database File
include("config/database.php");
include("include/alert.php");
include("include/middleware.php");

// Connect Database
$conn = database_Connect();

if(isset($_GET['id']) && $_GET['id']!=null) {

    // SQL Query to retrieve user information based on the provided ID
    $sql = "SELECT * FROM users WHERE id=$_GET[id]";

    $result = $conn->query($sql);

    if($result->num_rows>0){
        // Extract Field from Associative Array 
        $users = mysqli_fetch_assoc($result);
    }
    else{
        $_SESSION['Error'] ="User not found";
        header("Location: users.php");
    }
}
else if(!isset($_GET['id']) || $_GET['id']==null){
    $_SESSION["Error"] = "Invalid Request";
    header("Location: users.php");
}

// Extract Variables from the Array
extract($_POST);

if(isset($submit) && isset($username)){   
    
    if(empty(trim($username))){
        $_SESSION["Error"] = "Username cannot be empty";
        header("Location: $_SERVER[REQUEST_URI]");
    }
    else{

        $date=date("Y-m-d H:i:s");

        try {
            // Check if the provided username already exists in the database
            $sql = "SELECT username FROM users WHERE username='$username'";

            $result = $conn->query($sql);

            if($result->num_rows>0){
                $_SESSION["Error"] = "User $username Already Exist";
                header("Location: $_SERVER[REQUEST_URI]");
            }
            else{
                // Update existing user record in the database with the provided username and creation date
                $sql ="UPDATE users SET username = '$username', created_at='$date' WHERE id = $_GET[id]";

                if($conn->query($sql)){
                  $_SESSION['Sucess'] = "User $username Updated Sucessfully";
                  header("Location: users.php");
                  exit(); // Ensure script execution stops after redirection
                }
            }
        }
        catch(Exception $e) {
            $_SESSION["Error"] = "Error: ".$e->getMessage();
        }        
    }
}

// Close Database Connection
database_Close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/style.css" rel="stylesheet">
    <title>PHP CRUD Application</title>
</head>

<body>
    <section class="section">
        <h2>Edit User</h2>

        <form action="edit-user.php?id=<?php echo $users['id'];?>" method="post">
            <div class="container">
                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="username" value="<?php echo $users['username'];?>" required>
                <button type="submit" name="submit">Update</button>
            </div>
        </form>

        <div class="container" style="background-color:#f1f1f1">
            <a href="users.php" class="footerbtn">All Users</a>
            <a href="logout.php" class="footerbtn">Logout</a>
        </div>
    </section>
</body>
</html>