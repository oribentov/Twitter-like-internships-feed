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
    <h2>Add new user</h2>
</div>

<!--add new user form-->
<div class="container">
<form method="post" action="create_user.php">

    <?php echo display_error(); ?>

    <div class="form-group">
        <label>First name</label>
        <input type="text" class="form-control" name="first_name_input">
    </div>
    <div class="form-group">
        <label>Last name</label>
        <input type="text" class="form-control" name="last_name_input">
    </div>
    <div class="form-group">
        <label>Username</label>
        <input type="text" class="form-control" name="username_input">
    </div>
    <div class="form-group">
        <label>Date of birth</label>
        <input type="date" class="form-control" name="date_of_birth_input">
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" name="email_input">
    </div>
    <div class="form-group">
        <label>Title</label>
        <select class="form-control" name="title_input" id="title_input" >
            <option value="student">Student</option>
            <option value="lecturer">Lecturer</option>
            <option value="admin">Admin</option>
        </select>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" name="password_input">
    </div>
    <div class="form-group">
        <label>Confirm password</label>
        <input type="password" class="form-control" name="password2_input">
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary" name="register_btn">Create user</button>
    </div>
</form>
</div>
</body>
</html>