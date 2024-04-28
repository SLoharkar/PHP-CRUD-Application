<!-- index.php file -->

<?php 

// Include Database Connection
include("config/database.php"); 
include("include/alert.php");

$conn = database_Connect();

// Function to sanitize user input
function sanitize($data) {
    return htmlspecialchars(trim($data));
}


if(isset($_POST['submit'])){
    extract($_POST); // Extract POST data into variables

    // Sanitize extracted variables
    $username = sanitize($username);
    $password = sanitize($password);

    // Hash the password using MD5 (not recommended for new applications, use password_hash() instead)
    $pass = md5($password);

    // SQL Query to fetch user from database
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$pass'";
    
    $result = $conn->query($sql);

    if($result->num_rows){
        $_SESSION['user_login_status']=true;
        $_SESSION['Sucess']="User $username Login Sucessfully";
        header("Location: users.php");
        exit(); // Ensure script execution stops after redirection
    }
    else{
        $_SESSION['Error'] = "Invalid Username or Password";
        header("Location: index.php");
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
        <h2>Login Form</h2>

        <form action="index.php" method="post">
            <div class="container">
                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="username" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" required>

                <button type="submit" name="submit">Login</button>
            </div>
        </form>
        <div class="container" style="background-color:#f1f1f1">
            <a href="add-user.php" class="footerbtn">Register New User</a>
            <a href="index.php" class="footerbtn">Refresh</a>
        </div>
    </section>
</body>
</html>