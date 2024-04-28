<?php
// Include Database Connection
include("config/database.php");
include("include/alert.php");
include("include/middleware.php");

// Connect Database
$conn = database_Connect();

// Retrieve all user records from the database
$sql = "SELECT * FROM users";

$result=$conn->query($sql);

// Delete User Code
if(isset($_GET['id']) && $_GET['id']!=null) {

    // Sanitize the input to prevent SQL injection
    $id = intval($_GET['id']);

    // Delete user record from the database based on the provided ID
    $sql1 = "DELETE FROM users WHERE id=$id";

    $result1 = $conn->query($sql1);

    if($result1 && $conn->affected_rows>0){       
        $_SESSION['Sucess'] = "Record Deleted Sucessfully";
        header("Location: users.php");
    }
    else{
        $_SESSION['Error'] = "Record not Found";
        header("Location: users.php");
    }
}

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
        <h2>All Users</h2>

        <table id="users">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $row['username'] ?>
                            </td>
                            <td>
                                <?php echo date("d-m-Y h:i A", strtotime($row['created_at']))  ?>
                            </td>
                            <td>
                                <a href="edit-user.php?id=<?php echo $row['id'] ?>" class="button edit">Edit</a>
                                <a href="users.php?id=<?php echo $row['id'] ?>" class="button delete">Delete</a>
                            </td>
                        </tr>
                    <?php  }
            } else {
                echo "<tr><td colspan='3'>No record found!</td></tr>";
            }
            ?>
            </tbody>
        </table>

        <div class="container" style="background-color:#f1f1f1">
            <a href="logout.php" class="footerbtn">Logout</a>
            <a href="users.php" class="footerbtn">Refresh</a>
        </div>
    </section>
</body>
</html>

<?php 
// Close Database Connection
database_Close($conn);
?>