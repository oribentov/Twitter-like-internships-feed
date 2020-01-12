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
    <h2>Edit internship</h2>
</div>

<?php
$id = $_GET['channel'];
$results = mysqli_query($conn, "SELECT * FROM channels WHERE channel_id='$id'");
$row = mysqli_fetch_array($results);
?>

<div class="container">
<form method="post" action="editinternship.php">

    <?php echo display_error(); ?>

    <div class="form-group">
        <input type="text" class="form-control" name="channel_input" value="<?php echo $row['channel_id']; ?>" hidden>
    </div>
    <div class="form-group">
        <label>Title</label>
        <input type="text" class="form-control" name="title_input" value="<?php echo $row['channel_title']; ?>">
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea class="form-control" name="description_input" rows="5"><?php echo $row['channel_description']; ?></textarea>
    </div>
    <div class="form-group">
        <label>Student</label>
        <select class="form-control" name="student_input" id="title_input">
            <?php
            $studentId = $row['student'];
            $userQuery = mysqli_query($conn, "SELECT * FROM users WHERE user_id='$studentId'");
            $userRow = mysqli_fetch_array($userQuery);
            if(mysqli_num_rows($userQuery) > 0)
                $currentStudent = $userRow['first_name'] . " " . $userRow['last_name'];
            else
                $currentStudent = 'Not yet selected';
            ?>
            <option value="<?php echo $userRow['user_id']; ?>"><?php echo $currentStudent; ?></option>
            <?php
            $usersQuery = mysqli_query($conn, "SELECT * FROM users WHERE title='Student' AND status='enabled'");
            while ($userRow = mysqli_fetch_array($usersQuery)) { ?>
            <option value="<?php echo $userRow['user_id']; ?>"><?php echo $userRow['first_name'] . " " . $userRow['last_name'] ; ?></option>
            <?php } ?>
            <option value="none">none</option>
        </select>

    </div>
    <div class="form-group">
        <label>Local supervisor</label>
        <select class="form-control" name="local_input">
            <?php
            $lecturerId = $row['local_supervisor'];
            $lecturerQuery = mysqli_query($conn, "SELECT * FROM users WHERE user_id='$lecturerId'");
            $lecturerRow = mysqli_fetch_array($lecturerQuery);
            if(mysqli_num_rows($lecturerQuery) > 0)
                $currentLocal = $lecturerRow['first_name'] . " " . $lecturerRow['last_name'];
            else
                $currentLocal = 'Not yet selected';
            ?>
            ?>
            <option value="<?php echo $lecturerRow['user_id']; ?>"><?php echo $currentLocal; ?></option>

            <?php
            $lecturerQuery = mysqli_query($conn, "SELECT * FROM users WHERE title='Lecturer' AND status='enabled'");
            while ($lecturerRow = mysqli_fetch_array($lecturerQuery)) { ?>
                <option value="<?php echo $lecturerRow['user_id']; ?>"><?php echo $lecturerRow['first_name'] . " " . $lecturerRow['last_name'] ; ?></option>
            <?php } ?>
            <option value="none">none</option>
        </select>
    </div>
    <div class="form-group">
        <label>Academic supervisor</label>
        <select class="form-control" name="academic_input" value="<?php echo $row['academic_supervisor']; ?>">
            <?php
            $lecturerId = $row['academic_supervisor'];
            $lecturerQuery = mysqli_query($conn, "SELECT * FROM users WHERE user_id='$lecturerId'");
            $lecturerRow = mysqli_fetch_array($lecturerQuery);
            if(mysqli_num_rows($lecturerQuery) > 0)
                $currentAcademic = $lecturerRow['first_name'] . " " . $lecturerRow['last_name'];
            else
                $currentAcademic = 'Not yet selected';
            ?>
            ?>
            <option value="<?php echo $lecturerRow['user_id']; ?>"><?php echo $currentAcademic; ?></option>

            <?php
            $lecturerQuery = mysqli_query($conn, "SELECT * FROM users WHERE title='Lecturer' AND status='enabled'");
            while ($lecturerRow = mysqli_fetch_array($lecturerQuery)) { ?>
                <option value="<?php echo $lecturerRow['user_id']; ?>"><?php echo $lecturerRow['first_name'] . " " . $lecturerRow['last_name'] ; ?></option>
            <?php } ?>
            <option value="none">none</option>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary" name="edit_internship_btn">update internship</button>
    </div>
</form>
</div>
</body>
</html>