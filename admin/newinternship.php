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
    <h2>add new internship</h2>
</div>

<!--add new internship form-->
<div class="container">
<form method="post" action="newinternship.php">

    <?php echo display_error(); ?>

    <div class="form-group">
        <label>Title</label>
        <input type="text" class="form-control" name="title_input">
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea class="form-control" name="description_input" rows="5"></textarea>
    </div>
    <div class="form-group">
        <label>Student</label>
        <select class="form-control" name="student_input">
            <option value="none">none</option>
            <?
            $usersQuery = mysqli_query($conn, "SELECT * FROM users WHERE title='Student' AND status='enabled'");
            while ($userRow = mysqli_fetch_array($usersQuery)) { ?>
                <option value="<?php echo $userRow['user_id']; ?>"><?php echo $userRow['first_name'] . " " . $userRow['last_name'] ; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label>Local supervisor</label>
        <select class="form-control" name="local_input">
            <option value="none">none</option>
            <?php
            $lecturerQuery = mysqli_query($conn, "SELECT * FROM users WHERE title='Lecturer' AND status='enabled'");
            while ($lecturerRow = mysqli_fetch_array($lecturerQuery)) { ?>
            <option value="<?php echo $lecturerRow['user_id']; ?>"><?php echo $lecturerRow['first_name'] . " " . $lecturerRow['last_name'] ; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label>Academic supervisor</label>
        <select class="form-control" name="academic_input">
            <option value="none">none</option>
            <?php
            $lecturerQuery = mysqli_query($conn, "SELECT * FROM users WHERE title='Lecturer' AND status='enabled'");
            while ($lecturerRow = mysqli_fetch_array($lecturerQuery)) { ?>
                <option value="<?php echo $lecturerRow['user_id']; ?>"><?php echo $lecturerRow['first_name'] . " " . $lecturerRow['last_name'] ; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary" name="new_internship_btn">Post internship</button>
    </div>
</form>
</div>
</body>
</html>