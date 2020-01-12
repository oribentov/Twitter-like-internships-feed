<?php include('functions.php');
$x = bin2hex(random_bytes(16));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>internships for BINFO students</title>
    <link rel="stylesheet" type="text/css" href="./src/bootstrap.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-sha256/0.9.0/sha256.js" type="text/javascript"></script>
</head>
<body>
	<div class="container">
<div class="header">
    <h2>Welcome to interships for BINFO students</h2>
</div>
<!-- notification message -->
<?php if (isset($_SESSION['msg'])) : ?>
    <div class="alert alert-success" role="alert">
        <?php
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
        ?>
    </div>
<?php endif ?>
<div>
    <form id="login_form" method="post">
        <?php echo display_error(); ?>
        <input type="text" name="x_salt" id="x_salt" value="<?php echo $x ?>" hidden/>
        <p>Username:</p>
        <input type="text" id="username_input" name="username_input" />
        <p>password:</p>
        <input type="password" id="password_input" name="password_input" />
        <input type="submit" value="login" name="login_btn">
        <p>
            Not yet a member? <a href="register.php">Sign up</a>
        </p>
    </form>
</div>
</body>
<script>
    $(document).ready(function() {
        $('#login_form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: 'src/encryption.php',
                data: {username_input: document.getElementById("username_input").value, x_salt: document.getElementById("x_salt").value},
                success: function(response)
                {
                    var jsonResponse = JSON.parse(response);
                    if (jsonResponse.success == "1")
                    {
                        var hashStr = sha256(document.getElementById("x_salt").value + document.getElementById("password_input").value + jsonResponse.d_pepper);
                        console.log(hashStr);
                        $.ajax({
                            type: 'POST',
                            url: 'src/encryption.php',
                            data: {hashedStr : hashStr, username_input: document.getElementById("username_input").value},
                            success: function(responseHash) {
                                jsonResponseAuthentication = JSON.parse(responseHash);
                                console.log(jsonResponseAuthentication); // sanity check for getsalt response
                                if (jsonResponseAuthentication.success == "1"){
                                    window.location.href = "index.php";
                                } else {
                                    alert(jsonResponseAuthentication.error);
                                }
                            }
                        });
                    }
                    else
                    {
                        alert('you muse enter username and password');
                    }
                }
            });
        });
    });

</script>
</html>
