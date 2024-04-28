<?php
// Include Database File
include("config/database.php");
include("include/alert.php");

// Connect Database
$conn = database_Connect();

// Extract Variables from the Array
extract($_POST);

if(isset($submit) && isset($username) && isset($password)){   
    
    if(empty(trim($username)) || empty(trim($password))){
        $_SESSION["Error"] = "Username or Password cannot be empty";
        header("Location: add-user.php");
    }
    else {

        $date=date("Y-m-d H:i:s");

        try {
            
            // Check User Already Exist Database
            $sql = "SELECT username FROM users WHERE username='$username'";

            $result = $conn->query($sql);

            if($result->num_rows>0){
                $_SESSION["Error"] = "User $username Already Exist";
                header("Location: add-user.php");
            }
            else{

                // Register New User in Database

                $pass = md5($password);

                $sql ="INSERT INTO users (username,password,created_at) VALUES('$username','$pass','$date')";

                if($conn->query($sql)){
                    $_SESSION['Sucess'] = "User $username Registration Sucessfully";
                    $_SESSION['user_login_status']=true;
                    header("Location: users.php");
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
        <h2>Registration Form</h2>

        <form action="add-user.php" method="post">
            <div class="container">
                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="username" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" required>

                <button type="submit" name="submit">Signup</button>
            </div>
        </form>

        <div class="container" style="background-color:#f1f1f1">
            <a href="index.php" class="footerbtn">Login</a>
            <a href="add-user.php" class="footerbtn">Refresh</a>
        </div>
    </section>
</body>
</html>