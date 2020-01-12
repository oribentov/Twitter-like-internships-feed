<?php
require_once "config.php";
$errors = array();

// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
    register();
}

// register function
function register()
{
    global $conn, $errors;

    // receive all input values
    $firstName = mysqli_real_escape_string($conn, $_POST['first_name_input']);
    $lastName = mysqli_real_escape_string($conn, $_POST['last_name_input']);
    $username = mysqli_real_escape_string($conn, $_POST['username_input']);
    $dateOfBirth = date('Y-m-d', strtotime($_POST['date_of_birth_input']));
    $email = mysqli_real_escape_string($conn, $_POST['email_input']);
    $title = mysqli_real_escape_string($conn, $_POST['title_input']);
    $password_1 = mysqli_real_escape_string($conn, $_POST['password_input']);
    $password_2 = mysqli_real_escape_string($conn, $_POST['password2_input']);

    // form validation
    if (empty($firstName)) {
        array_push($errors, "first name is required");
    }
    if (empty($lastName)) {
        array_push($errors, "last name is required");
    }
    if (empty($username)) {
        array_push($errors, "username is required");
    }
    if (empty($dateOfBirth)) {
        array_push($errors, "date of birth is required");
    }
    if (empty($email)) {
        array_push($errors, "email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    // register user if there are no errors
    if (count($errors) == 0) {

        if (isset($_POST['title_input'])) {
            $insert = mysqli_query($conn, "INSERT INTO users (`first_name`, `last_name`, `username`, `password`, `title`, `email`, `date_of_birth`) 
            VALUES ('$firstName', '$lastName', '$username', '$password_1', '$title', '$email', '$dateOfBirth');")
            or die(mysqli_error($conn));

            if ($insert) {
                $_SESSION['success'] = "New user successfully created!!";
                //header('location: index.php');
                header("Location: ". BASE_URL);
            } else {
                echo 'fail';
            }
        } else {
            $insert = mysqli_query($conn, "INSERT INTO users (`first_name`, `last_name`, `username`, `password`, `title`, `email`, `date_of_birth`, `salt`, `date_created`) 
            VALUES ('$firstName', '$lastName', '$username', '$password_1', '$title', '$email', $dateOfBirth);")
            or die(mysqli_error($conn));

            $logged_in_user_id = mysqli_insert_id($conn);
            $_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
        }
    }
}

function getUserById($id){
    global $conn;
    $query = "SELECT * FROM users WHERE user_id='$id'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
    }

    return $user;
}

// display errors from errors array
function display_error() {
    global $errors;

    if (count($errors) > 0){
        echo '<div class="error">';
        foreach ($errors as $error){
            echo $error .'<br>';
        }
        echo '</div>';
    }
}

// log user out
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: login.php");
}

// return if the user connected to the system
function isLoggedIn()
{
    if (isset($_SESSION['user'])) {
        return true;
    }else{
        return false;
    }
}

// return if the user is admin
function isAdmin()
{
    if (isset($_SESSION['user']) && $_SESSION['user']['title'] == 'admin' ) {
        return true;
    }else{
        return false;
    }
}

// return if the user is subscribed to a specific internship
function isSubscribed()
{
    global $conn;

    $channel_id = $_GET['channel'];
    $results = mysqli_query($conn, "SELECT * FROM channels WHERE channel_id='$channel_id'");
    $row = mysqli_fetch_array($results);

    if ($_SESSION['user']['user_id']  == $row['student'] || $_SESSION['user']['user_id']  == $row['local_supervisor'] || $_SESSION['user']['user_id']  == $row['academic_supervisor']) {
        return true;
    }else{
        return false;
    }
}

// return if the user has any internship subscribed
function isHaveInternship()
{
    global $conn;
    $userId = $_SESSION['user']['user_id'];

    $result = mysqli_query($conn, "SELECT * FROM channels WHERE student='$userId'");
    if (mysqli_num_rows($result) > 0) {
        return true;
    }else{
        return false;
    }
}

// call the edit() function if edit_btn is clicked
if (isset($_POST['edit_btn'])) {
    edit();
}

// edit user function
function edit()
{
    global $conn, $errors, $firstName, $lastName, $username, $dateOfBirth, $email, $title;

    $userId = mysqli_real_escape_string($conn, $_POST['user_id_input']);
    $firstName = mysqli_real_escape_string($conn, $_POST['first_name_input']);
    $lastName = mysqli_real_escape_string($conn, $_POST['last_name_input']);
    $username = mysqli_real_escape_string($conn, $_POST['username_input']);
    $dateOfBirth = mysqli_real_escape_string($conn, $_POST['date_of_birth_input']);
    $email = mysqli_real_escape_string($conn, $_POST['email_input']);
    $title = mysqli_real_escape_string($conn, $_POST['title_input']);

    // form validation
    if (empty($firstName)) {
        array_push($errors, "first name is required");
    }
    if (empty($lastName)) {
        array_push($errors, "last name is required");
    }
    if (empty($username)) {
        array_push($errors, "username is required");
    }
    if (empty($dateOfBirth)) {
        array_push($errors, "date of birth is required");
    }
    if (empty($email)) {
        array_push($errors, "email is required");
    }
    if (empty($title)) {
        array_push($errors, "title is required");
    }

    if (count($errors) == 0) {
        $insert = mysqli_query($conn, "UPDATE users SET first_name='$firstName', last_name='$lastName', username='$username',
        date_of_birth='$dateOfBirth', email='$email', title='$title' WHERE user_id='$userId'")
        or die(mysqli_error($conn));

        if ($insert) {
            $_SESSION['success'] = "user edited successfully";
            header("Location: allusers.php");
        } else {
            echo 'fail';
        }
    }
}

// if delete internship was pressed
if (isset($_GET['channeldel'])) {
    deleteInternship();
}

// delete internship
function deleteInternship()
{
    global $conn;
    $channelId = $_GET['channeldel'];

    $deleteQuery = mysqli_query($conn, "DELETE FROM channels WHERE channel_id='$channelId'")
    or die(mysqli_error($conn));

    if ($deleteQuery) {
        $_SESSION['success'] = "Internship deleted successfully";
        header("Location: index.php");
    } else {
        echo 'error';
    }
}

if (isset($_GET['disable'])){
    disable();
}

// disable user
function disable()
{
    global $conn;

    $userId = $_GET['disable'];
    $disabled = "disabled";
    $update = mysqli_query($conn, "UPDATE users SET status='$disabled' WHERE user_id='$userId'") or die(mysqli_error($conn));

    if ($update) {
        $_SESSION['success'] = "user disabled successfully";
        header("Location: allusers.php");
    } else {
        echo 'failed';
    }
}

if (isset($_GET['enable'])){
    enable();
}

// enable user
function enable()
{
    global $conn;

    $userId = $_GET['enable'];
    $disabled = "enabled";
    $update = mysqli_query($conn, "UPDATE users SET status='$disabled' WHERE user_id='$userId'") or die(mysqli_error($conn));

    if ($update) {
        $_SESSION['success'] = "user enabled successfully";
        header("Location: allusers.php");
    } else {
        echo 'failed';
    }
}

if (isset($_POST['tweet_btn'])) {
    postTweet();
}

// add tweet (message) to internship
function postTweet()
{
    global $conn, $errors;
    $tweetInput = mysqli_real_escape_string($conn, $_POST['tweet_input']);

    // form validation
    if (empty($tweetInput)) {
        array_push($errors, "you have to write something to post");
    }

    if (count($errors) == 0) {
        $userId = $_SESSION['user']['user_id'];
        $channelId = mysqli_real_escape_string($conn, $_POST['channel_id']);
        $date = date("Y-m-d H:i:s");

        $insert = mysqli_query($conn, "INSERT INTO replies (`user_id`, `channel_id`, `comment`, `date_posted`) 
            VALUES ('$userId', '$channelId', '$tweetInput', '$date');")
            or die(mysqli_error($conn));

        if ($insert) {
            header('Location: '.$_SERVER['REQUEST_URI'] ."?channel=".$channelId);
        }
    }
}

if (isset($_POST['new_internship_btn'])) {
    newIntern();
}

// add new internship function
function newIntern()
{
    global $conn, $errors;

    $title = mysqli_real_escape_string($conn, $_POST['title_input']);
    $description = mysqli_real_escape_string($conn, $_POST['description_input']);
    $student = mysqli_real_escape_string($conn, $_POST['student_input']);
    $local = mysqli_real_escape_string($conn, $_POST['local_input']);
    $academic = mysqli_real_escape_string($conn, $_POST['academic_input']);
    $date = date("Y-m-d H:i:s");

    // form validation
    if (empty($title)) {
        array_push($errors, "first name is required");
    }
    if (empty($description)) {
        array_push($errors, "last name is required");
    }

    if (count($errors) == 0) {
        $insert = mysqli_query($conn, "INSERT INTO `channels`(`channel_title`, `channel_description`, `student`, `local_supervisor`, `academic_supervisor`, `date_posted`)
            VALUES ('$title', '$description', '$student', '$local', '$academic', '$date');")
        or die(mysqli_error($conn));

        if ($insert) {
            $_SESSION['success'] = "Internship created successfully!";
            header("Location: ../index.php");
        } else {
            echo 'fail';
        }
    }
}

if (isset($_POST['edit_internship_btn'])) {
    editInternship();
}

// edit internship function
function editInternship()
{
    global $conn, $errors;

    $channelId = mysqli_real_escape_string($conn, $_POST['channel_input']);
    $title = mysqli_real_escape_string($conn, $_POST['title_input']);
    $description = mysqli_real_escape_string($conn, $_POST['description_input']);
    $student = mysqli_real_escape_string($conn, $_POST['student_input']);
    $local = mysqli_real_escape_string($conn, $_POST['local_input']);
    $academic = mysqli_real_escape_string($conn, $_POST['academic_input']);

    // form validation
    if (empty($title)) {
        array_push($errors, "first name is required");
    }
    if (empty($description)) {
        array_push($errors, "last name is required");
    }

    if (count($errors) == 0) {
        $update = mysqli_query($conn, "UPDATE channels SET channel_title='$title', channel_description='$description', student='$student',
        local_supervisor='$local', academic_supervisor='$academic' WHERE channel_id='$channelId'")
        or die(mysqli_error($conn));

        if ($update) {
            $_SESSION['success'] = "internship edited successfully";
            header("Location: ".BASE_URL."/index.php");
        } else {
            echo 'fail';
        }
    }
}

if (isset($_POST['enroll_btn'])) {
    enroll();
}

// enroll to specific internship function
function enroll()
{
    global $conn;
    $userId = $_SESSION['user']['user_id'];
    $channelId = mysqli_real_escape_string($conn, $_POST['channel_id']);

    $update = mysqli_query($conn, "UPDATE channels SET student='$userId' WHERE channel_id='$channelId'")
    or die(mysqli_error($conn));

    if ($update) {
        $_SESSION['success'] = "You now enrolled to this internship";
        header('Location: '.$_SERVER['PHP_SELF']."?channel=".$channelId);
    } else {
        echo 'fail';
    }
}

if (isset($_POST['unenroll_btn'])) {
    unenroll();
}

// unenroll from specific internship function
function unenroll()
{
    global $conn;
    $channelId = mysqli_real_escape_string($conn, $_POST['channel_id']);

    $update = mysqli_query($conn, "UPDATE channels SET student='' WHERE channel_id='$channelId'")
    or die(mysqli_error($conn));

    if ($update) {
        $_SESSION['success'] = "You unenrolled from the internship successfully";
        header('Location: '.$_SERVER['PHP_SELF']."?channel=".$channelId);
    } else {
        echo 'fail';
    }
}

if (isset($_GET['myinternship'])){
    myInternship();
}

// return the user's internship (which subscribed to)
function myInternship()
{
    global $conn;
    $userId = $_SESSION['user']['user_id'];
    $query = "SELECT * FROM channels WHERE student='$userId' OR local_supervisor=$userId OR academic_supervisor=$userId";
    $result = mysqli_query($conn, $query);
    //echo $result, $query;
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);
        $channelId = $row['channel_id'];
        header("Location: intershippage.php?channel=".$channelId);
    } else {
        $_SESSION['msg'] = "You are not enrolled for any internship yet.";
        header("locatoin: index.php");
    }
}


