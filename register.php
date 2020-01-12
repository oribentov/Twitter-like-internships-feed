<?php include('functions.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>internships for BINFO students</title>
    <link rel="stylesheet" type="text/css" href="./src/bootstrap.css"></head>
<body>
<?php include("./layouts/navbar.php") ?>
<h2>Register to BIMFO-Lux internships</h2>

<div>
    <form action="register.php" method="post">
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
            <input type="date" class="form-control" name="date_of_birth_input" value="<?php echo date('Y-m-d'); ?>">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email_input">
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
            <button type="submit" class="btn btn-primary" name="register_btn">Register</button>
        </div>
    </form>
</div>
</body>
</html>
