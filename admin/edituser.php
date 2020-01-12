<?php
include('../functions.php');

if (!isAdmin()) {
    $_SESSION['msg'] = "this page available only for admin users";
    header('location: ../login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>internships for BINFO students</title>
    <link rel="stylesheet" type="text/css" href="../src/bootstrap.css">
</head>
<body>

<?php include("../layouts/admin_navbar.php") ?>

<div class="header">
    <h2>edit user</h2>
</div>

<!--add new user form-->
    <?php
     $id = $_GET['edit'];
     $results = mysqli_query($conn, "SELECT * FROM users WHERE user_id='$id'");
     $row = mysqli_fetch_array($results);
    ?>
<div class="container">
    <form method="post" action="edituser.php">

        <?php echo display_error(); ?>

        <div class="form-group">
            <input type="text" class="form-control" name="user_id_input" value="<?php echo $row['user_id']; ?>" hidden>
        </div>
        <div class="form-group">
            <label>First name</label>
            <input type="text" class="form-control" name="first_name_input" value="<?php echo $row['first_name']; ?>">
        </div>
        <div class="form-group">
            <label>Last name</label>
            <input type="text" class="form-control" name="last_name_input" value="<?php echo $row['last_name']; ?>">
        </div>
        <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control" name="username_input" value="<?php echo $row['username']; ?>">
        </div>
        <div class="form-group">
            <label>Date of birth</label>
            <input type="date" class="form-control" name="date_of_birth_input" value="<?php echo $row['date_of_birth']; ?>">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email_input" value="<?php echo $row['email']; ?>">
        </div>
        <div class="form-group">
            <label>Title</label>
            <select class="form-control" name="title_input" id="title_input">
                <option value="student">Student</option>
                <option value="admin">Admin</option>
                <option value="lecturer">Lecturer</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" name="edit_btn">update user</button>
        </div>
    </form>
</div>
</body>
</html>