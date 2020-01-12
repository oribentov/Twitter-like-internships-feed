<?php
include ('functions.php');

$channel_id = $_GET['channel'];
$results = mysqli_query($conn, "SELECT * FROM channels WHERE channel_id='$channel_id'");
$row = mysqli_fetch_array($results);

if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>internships for BINFO students</title>
    <link rel="stylesheet" type="text/css" href="./src/bootstrap.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>
<body>
<?php if(isAdmin()) {
    include("./layouts/admin_navbar.php");
}   else {
    include("./layouts/navbar.php");
}?>

<!-- notification message -->
<?php if (isset($_SESSION['success'])) : ?>
    <div class="alert alert-success" role="alert">
        <?php
        echo $_SESSION['success'];
        unset($_SESSION['success']);
        ?>
    </div>
<?php endif ?>

<div class="header">
    <h2><?php echo $row['channel_title']; ?></h2>
</div>
<div class="container">
<p>
    <strong>Desciption: </strong><?php echo $row['channel_description']; ?>
</p>
<p>
    <strong>Student: </strong><?php
    $studentId = $row['student'];
    $userQuery = mysqli_query($conn, "SELECT * FROM users WHERE user_id='$studentId'");
    $userRow = mysqli_fetch_array($userQuery);
    if(mysqli_num_rows($userQuery) > 0)
        echo $userRow['first_name'] . " " . $userRow['last_name'];
    else
        echo 'Not yet selected';
    ?>
</p>
<p>
    <strong>Local supervisor: </strong><?php
    $lecturerId = $row['local_supervisor'];
    $lecturerQuery = mysqli_query($conn, "SELECT * FROM users WHERE user_id='$lecturerId'");
    $lecturerRow = mysqli_fetch_array($lecturerQuery);
    if(mysqli_num_rows($lecturerQuery) > 0)
        echo $lecturerRow['first_name'] . " " . $lecturerRow['last_name'];
    else
        echo 'Not yet selected';
    ?>
</p>
<p>
    <strong>Academic supervisor: </strong><?php
    $lecturerId = $row['academic_supervisor'];
    $lecturerQuery = mysqli_query($conn, "SELECT * FROM users WHERE user_id='$lecturerId'");
    $lecturerRow = mysqli_fetch_array($lecturerQuery);
    if(mysqli_num_rows($lecturerQuery) > 0)
        echo $lecturerRow['first_name'] . " " . $lecturerRow['last_name'];
    else
        echo 'Not yet selected';
    ?>
</p>

<?php if(!isSubscribed() && !isHaveInternship() &&  $_SESSION['user']['title'] == "student") { ?>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
    <input type="text" class="form-control" name="channel_id" value="<?php echo $channel_id; ?>" hidden>
    <button type="submit" class="btn btn-success" name="enroll_btn" onclick="return confirm('Are you sure you want to enroll to this internship?');">I want to enroll to this internship</button>
</form>
<?php } ?>

<?php if(isHaveInternship() && !isSubscribed() && $_SESSION['user']['title'] == "student") { ?>
<p class="alert alert-secondary">You are already enrolled to another internship. to join this internship, you need to unenroll from yours.</p>
<?php } ?>

<?php if(isSubscribed() && !isAdmin() && $_SESSION['user']['title'] == "student") { ?>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <input type="text" class="form-control" name="channel_id" value="<?php echo $channel_id; ?>" hidden>
        <button type="submit" class="btn btn-danger" name="unenroll_btn" onclick="return confirm('Are you sure you want to unenroll to this internship?');">I want to unenroll from this internship</button>
    </form>
<?php } ?>
</div>
<?php if(isAdmin() || isSubscribed()) { ?>
<hr class="style4">
<div class="container">
<form class="form-inline" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="tweet_form">
    <?php echo display_error(); ?>
    <input type="text" class="form-control" name="channel_id" value="<?php echo $channel_id; ?>" hidden>
    <div class="form-group">
        <textarea class="form-control" rows="2" name="tweet_input" form="tweet_form" placeholder="Tweet here"></textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary pull-right" name="tweet_btn">Tweet</button>
    </div>
</form>
    <div name="fliter_dates">
        Filter messages by dates: <input type="text" size="30" name="daterange" value="12/12/2020 - 1/1/2021" />
    </div>
    <?php
    if(isset($_GET['start'])) {
        $start = $_GET['start'];
        $end = $_GET['end'];
        $results = mysqli_query($conn, "SELECT * FROM replies WHERE channel_id='$channel_id' AND date_posted >= '$start' AND date_posted <= '$end' ORDER BY date_posted");
    }
    else {
        $results = mysqli_query($conn, "SELECT * FROM replies WHERE channel_id='$channel_id' ORDER BY date_posted");
    }
    if (mysqli_num_rows($results) == 0) {
    ?>
        No messages found on these dates
    <?php } ?>
   <div class="container">
       <hr class="style4"><strong><p>Messages:</p></strong>
<?php
while ($row = mysqli_fetch_array($results)) {
    $user_id = $row['user_id'];
    $userQuery = mysqli_query($conn, "SELECT * FROM users WHERE user_id='$user_id'");
    $userRow = mysqli_fetch_array($userQuery);
    if(mysqli_num_rows($userQuery) > 0)
        $userInfo = $userRow['first_name'] . " " . $userRow['last_name'];
?>
<!--    show all messages-->
<div class="col-sm-5">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong> <?php echo $userInfo ?></strong> <span class="text-muted"><?php echo $row['date_posted']; ?></span>
        </div>
        <div class="panel-body">
            <?php echo $row['comment']; ?>
        </div>
    </div>
</div>
    <?php } } ?>
   </div>
</body>
<script>
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            window.location.href = location.protocol + '//' + location.host + location.pathname+'?channel='+"<?php echo $channel_id?>"+'&start='+start.format('YYYY-MM-DD')+'&end='+end.format('YYYY-MM-DD');
        });
    });
</script>
</html>
