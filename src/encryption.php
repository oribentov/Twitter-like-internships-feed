<?php
include('../functions.php');

// if username and client salt is set, save in session and respond with the server salt
if (isset($_POST['username_input']) && $_POST['username_input'] && isset($_POST['x_salt']) && $_POST['x_salt']) {
    // set server salt current time (numbers)
    //$d_pepper = date('Y/m/d H:i:s');
    $d_pepper = time();
    // save client and server salt in session
    $_SESSION['d_pepper'] = $d_pepper;
    $_SESSION['x_salt'] = $_POST['x_salt'];
    echo json_encode(array(
        'success' => 1,
        'd_pepper' => $d_pepper,
    ));
} else if(!isset($_POST['hashedStr'])) {
    echo json_encode(array('success' => 0));
}





// if username is set and hashed password is set try to login securely
if (isset($_POST['username_input']) && $_POST['username_input'] && isset($_POST['hashedStr']) && $_POST['hashedStr']) {

    securedLogin();

}


// secured login with hash (no password in POST)
function securedLogin(){
    global $conn, $username, $errors;

    //TODO: delte errors (redundent)

    // set parameters from session and POST
    $xSalt = $_SESSION['x_salt'];
    $dPepper = $_SESSION['d_pepper'];
    $username = mysqli_real_escape_string($conn, $_POST['username_input']);
    $hashedStr = mysqli_real_escape_string($conn, $_POST['hashedStr']);

/*    // make sure form is filled properly
    if (empty($username)) {
        array_push($errors, "Username is required");
    }*/


    // attempt login if no errors on form
    if (count($errors) == 0) {

        //$query = ;
        $results = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' LIMIT 1")
        or die(mysqli_error($conn));

        $checkUser = mysqli_fetch_assoc($results);

        $dbPwd = $checkUser['password'];
        $hashedPass = hash('sha256',$xSalt . $dbPwd . $dPepper);
        //echo $hashedPass;
        if ($hashedStr == $hashedPass && $checkUser['password']) { // password is correct
            // check if user is active
            if($checkUser['status'] == 'enabled') {
                // auth OK, check if user is admin or user
                $_SESSION['user'] = $checkUser;
                $_SESSION['success']  = "You are now logged in";
                echo json_encode(array(
                    'success' => 1,
                ));
/*                if ($checkUser['title'] == 'admin') {
                    $_SESSION['user'] = $checkUser;
                    $_SESSION['success']  = "You are now logged in";
                    echo json_encode(array(
                        'success' => 1,
                        'admin' => 1,
                    ));
                    // auth OK, user is not admin
                }else{
                    $_SESSION['user'] = $logged_in_user;
                    $_SESSION['success']  = "You are now logged in";
                    echo json_encode(array(
                        'success' => 1,
                        'admin' => 0,
                    ));
                }*/
            }
            // auth OK, user status is disabled
            else {
                echo json_encode(array(
                    'success' => 0,
                    'error' => 'your user is disabled. please contact the admin.',
                ));
            }
            // auth failed, update error
        } else {
            echo json_encode(array(
                'success' => 0,
                'error' => 'Wrong username/password combination',
            ));
        }
    }
}